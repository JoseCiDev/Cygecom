<?php

namespace App\Providers;

use Exception;
use Carbon\Carbon;
use App\Services\S3;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use App\Enums\{PurchaseRequestType, PurchaseRequestStatus};
use App\Models\{
    ProductInstallment,
    ServiceInstallment,
    Product,
    Contract,
    ContractInstallment,
    CostCenterApportionment,
    PaymentInfo,
    PurchaseRequest,
    PurchaseRequestFile,
    PurchaseRequestProduct,
    RequestSuppliesFiles,
    Service
};

class PurchaseRequestService extends ServiceProvider
{
    /**
     * @return mixed Retorna todas solicitações com suas relações.
     */
    public function allPurchaseRequests()
    {
        return PurchaseRequest::with([
            'user.person.costCenter',
            'purchaseRequestFile',
            'costCenterApportionment.costCenter.company',
            'deletedByUser',
            'updatedByUser',
            'service.paymentInfo',
            'purchaseRequestProduct.category',
            'contract.installments',
            'product.installments'
        ]);
    }

    /**
     * @return mixed Retorna todas solicitações com suas relações, exceto deletados.
     */
    public function purchaseRequests()
    {
        return PurchaseRequest::with([
            'user.person.costCenter',
            'suppliesUser.person.costCenter',
            'purchaseRequestFile',
            'costCenterApportionment.costCenter.company',
            'deletedByUser',
            'updatedByUser',
            'service.paymentInfo',
            'purchaseRequestProduct.category',
            'purchaseRequestProduct.supplier',
            'contract.installments',
            'product.installments'
        ])->whereNull('deleted_at')->get();
    }

    /**
     * @return mixed Pelo id do usuário retorna todas solicitações com suas relações, exceto deletados.
     */
    public function purchaseRequestsByUser(int $id = null)
    {
        $id = $id ?? auth()->user()->id;

        return PurchaseRequest::with([
            'user.person.costCenter',
            'suppliesUser.person.costCenter',
            'purchaseRequestFile',
            'costCenterApportionment.costCenter.company',
            'deletedByUser',
            'updatedByUser',
            'service.paymentInfo',
            'purchaseRequestProduct.category',
            'purchaseRequestProduct.supplier',
            'contract.installments',
            'product.installments'
        ])->whereNull('deleted_at')->where('user_id', $id)->get();
    }

    /**
     * @return mixed Pelo status da solicitação retorna todas com suas relações, exceto deletadas.
     */
    public function requestsByStatus(array $status)
    {
        return PurchaseRequest::with([
            'user.person.costCenter',
            'suppliesUser.person.costCenter',
            'purchaseRequestFile',
            'costCenterApportionment.costCenter.company',
            'deletedByUser',
            'updatedByUser',
            'service.paymentInfo',
            'purchaseRequestProduct.category',
            'purchaseRequestProduct.supplier',
            'contract.installments',
            'product.installments'
        ])->whereNull('deleted_at')->whereIn('status', $status);
    }

    /**
     * @return mixed Pelo id retorna solicitação com suas relações, exceto deletada.
     */
    public function purchaseRequestById(int $id)
    {
        return PurchaseRequest::with([
            'user.person.costCenter',
            'suppliesUser.person.costCenter',
            'purchaseRequestFile',
            'costCenterApportionment.costCenter.company',
            'deletedByUser',
            'updatedByUser',
            'service.paymentInfo',
            'purchaseRequestProduct.category',
            'purchaseRequestProduct.supplier',
            'contract.installments',
            'product.installments'
        ])->whereNull('deleted_at')->where('id', $id)->first();
    }

    /**
     * @abstract Cria apenas entidade solicitação com relação do rateio e arquivo/link.
     * Deve ser chamada pelos métodos específicios de serviço, contrato ou produtos.
     */
    public function registerPurchaseRequest(array $data, UploadedFile|array|null $files)
    {
        return DB::transaction(function () use ($data, $files) {
            $data['user_id'] = auth()->user()->id;
            $purchaseRequest = PurchaseRequest::create($data);

            $type = $purchaseRequest->type;
            $id = $purchaseRequest->id;

            $this->saveCostCenterApportionment($purchaseRequest->id, $data);

            if (collect($files)->count()) {
                foreach ($files as $file) {
                    $originalNames[] = $file->getClientOriginalName();
                }
                $this->uploadFilesToS3($files, $type, $id, $originalNames);
            }

            return $purchaseRequest;
        });
    }

    /**
     * @return mixed Retorna solicitação criada.
     * @abstract Cria solicitação de serviço.
     * Executa método registerPurchaseRequest para criar entidade de solicitação e método saveService para salvar serviço.
     */
    public function registerServiceRequest(array $data, UploadedFile|array|null $files)
    {
        return DB::transaction(function () use ($data, $files) {
            $purchaseRequest = $this->registerPurchaseRequest($data, $files);
            $this->saveService($purchaseRequest->id, $data);
            return $purchaseRequest;
        });
    }

    /**
     * @return mixed Retorna solicitação criada.
     * @abstract Cria solicitação de contrato.
     * Executa método registerPurchaseRequest para criar entidade de solicitação e método saveContract para salvar contrato.
     */
    public function registerContractRequest(array $data, UploadedFile|array|null $files)
    {
        return DB::transaction(function () use ($data, $files) {
            $purchaseRequest = $this->registerPurchaseRequest($data, $files);
            $this->saveContract($purchaseRequest->id, $data);

            return $purchaseRequest;
        });
    }

    /**
     * @return mixed Retorna solicitação criada.
     * @abstract Cria solicitação de produto(s).
     * Executa método registerPurchaseRequest para criar entidade de solicitação e método saveProduct para salvar produto(s).
     */
    public function registerProductRequest(array $data, UploadedFile|array|null $files)
    {
        return DB::transaction(function () use ($data, $files) {
            $purchaseRequest = $this->registerPurchaseRequest($data, $files);
            $this->saveProducts($purchaseRequest->id, $data);

            return $purchaseRequest;
        });
    }

    /**
     * @abstract Atualiza apenas entidade solicitação com relação do rateio e arquivo/link.
     * Normalmente é chamada pelos métodos específicios de serviço, contrato ou produtos.
     * Pode ser chamada por suprimentos para atualizar status da solicitação.
     */
    public function updatePurchaseRequest(int $id, array $data, bool $isSuppliesUpdate = false, UploadedFile|array|null $files = null)
    {
        return DB::transaction(function () use ($id, $data, $isSuppliesUpdate, $files) {
            $purchaseRequest = PurchaseRequest::find($id);
            $purchaseRequest->updated_by = auth()->user()->id;
            $purchaseRequest->fill($data);
            $purchaseRequest->save();
            $type = $purchaseRequest->type;
            $id = $purchaseRequest->id;

            if ($isSuppliesUpdate) {
                return $purchaseRequest;
            }

            $this->saveCostCenterApportionment($id, $data);

            if (collect($files)->count()) {
                foreach ($files as $file) {
                    $originalNames[] = $file->getClientOriginalName();
                }
                $this->uploadFilesToS3($files, $type, $id, $originalNames);
            }

            return $purchaseRequest;
        });
    }

    public function uploadFilesToS3(UploadedFile|array $files, PurchaseRequestType $purchaseRequestType, int $requestId, array $originalNames, ?bool $isSupplies = false): void
    {
        $type = 'request-' . ($isSupplies ? "supplies-" : '') . $purchaseRequestType->value;

        $uploadFiles = S3::sendFiles($files, $type, $requestId);

        if (!$uploadFiles->success) {
            $msg = $uploadFiles->exception;
            throw new Exception($msg);
        }
        foreach ($uploadFiles->urls_bucket as $index => $filePath) {
            $isSupplies ? $this->saveRequestSuppliesFiles($requestId, $filePath, $originalNames[$index]) : $this->savePurchaseRequestFile($requestId, $filePath, $originalNames[$index]);
        }
    }

    /**
     * @abstract Atualiza solicitação de serviço.
     * Executa método updatePurchaseRequest para atualizar entidade de solicitação e método saveService para atualizar serviço.
     */
    public function updateServiceRequest(int $id, array $data, UploadedFile|array|null $files)
    {
        DB::transaction(function () use ($id, $data, $files) {
            $purchaseRequest = $this->updatePurchaseRequest($id, $data, false, $files);
            $this->saveService($purchaseRequest->id, $data, $purchaseRequest->service->id);
        });
    }

    /**
     * @abstract Atualiza solicitação de produto(s).
     * Executa método updatePurchaseRequest para atualizar entidade de solicitação e método saveProduct para atualizar produto(s).
     */
    public function updateProductRequest(int $id, array $data,  UploadedFile|array|null $files)
    {
        DB::transaction(function () use ($id, $data, $files) {
            $purchaseRequest = $this->updatePurchaseRequest($id, $data, false, $files);
            $this->saveProducts($purchaseRequest->id, $data);
        });
    }

    /**
     * @abstract Atualiza solicitação de contrato.
     * Executa método updatePurchaseRequest para atualizar entidade de solicitação e método saveContract para atualizar contrato.
     */
    public function updateContractRequest(int $id, array $data, UploadedFile|array|null $files)
    {
        DB::transaction(function () use ($id, $data, $files) {
            $purchaseRequest = $this->updatePurchaseRequest($id, $data, false, $files);
            $this->saveContract($purchaseRequest->id, $data, $purchaseRequest->contract->id);
        });
    }

    /**
     * @abstract Soft delete em solicitação pelo id
     */
    public function deletePurchaseRequest(int $id)
    {
        $purchaseRequest = PurchaseRequest::find($id);
        $purchaseRequest->deleted_at = Carbon::now();
        $purchaseRequest->deleted_by = auth()->user()->id;
        $purchaseRequest->save();
    }

    /**
     * @abstract Responsável por criar, atualizar ou remover relações de rateios com centro de custo
     */
    private function saveCostCenterApportionment(int $purchaseRequestId, array $data)
    {
        $userId = auth()->user()->id;
        $apportionmentData = $data['cost_center_apportionments'];
        $existingIds = CostCenterApportionment::where('purchase_request_id', $purchaseRequestId)->pluck('id')->toArray();

        foreach ($apportionmentData as $apportionment) {
            $apportionment['purchase_request_id'] = $purchaseRequestId;
            $apportionment['updated_by'] = $userId;
            $existingRecord = CostCenterApportionment::where(['purchase_request_id' => $purchaseRequestId, 'cost_center_id' => $apportionment['cost_center_id']])->first();

            if ($existingRecord) {
                if (isset($apportionment['apportionment_currency'])) {
                    $apportionment['apportionment_percentage'] = null;
                } elseif (isset($apportionment['apportionment_percentage'])) {
                    $apportionment['apportionment_currency'] = null;
                }

                $existingRecord->update($apportionment);
                $existingIds = array_diff($existingIds, [$existingRecord->id]);
            } else {
                CostCenterApportionment::create($apportionment);
            }
        }

        CostCenterApportionment::whereIn('id', $existingIds)->delete();
    }

    /**
     * @abstract Responsável por criar ou atualizar purchaseRequestFile.
     * Recomendado executar com o método específico registerProductRequest ou updateProductRequest
     */
    private function savePurchaseRequestFile(int $purchaseRequestId, $filePath, string $originalName)
    {
        $purchaseRequestFile['path'] = $filePath;
        $purchaseRequestFile['purchase_request_id'] = $purchaseRequestId;
        $purchaseRequestFile['updated_by'] = auth()->user()->id;
        $purchaseRequestFile['original_name'] = $originalName; // Atribuir apenas o nome original, não o array

        PurchaseRequestFile::create($purchaseRequestFile);
    }

    /**
     * @abstract Responsável por criar ou atualizar purchaseRequestFile.
     * Recomendado executar com o método específico registerProductRequest ou updateProductRequest
     */
    private function saveRequestSuppliesFiles(int $purchaseRequestId, $filePath, string $originalName)
    {
        $requestSuppliesFiles['path'] = $filePath;
        $requestSuppliesFiles['purchase_request_id'] = $purchaseRequestId;
        $requestSuppliesFiles['updated_by'] = auth()->user()->id;
        $requestSuppliesFiles['original_name'] = $originalName;

        RequestSuppliesFiles::create($requestSuppliesFiles);
    }


    /**
     * @abstract Responsável por criar ou atualizar service.
     * Recomendado executar com o método específico registerServiceRequest ou updateServiceRequest
     */
    private function saveService(int $purchaseRequestId, array $data, ?int $serviceId = null): void
    {
        $serviceData = $data['service'];

        // caso disabled os campos do form define como null
        $serviceInstallmentsData = $serviceData['service_installments'] ?? [];
        $paymentInfoData = $serviceData['payment_info'] ?? [];

        if (!empty(array_filter($paymentInfoData))) {
            $paymentInfoResponse = PaymentInfo::updateOrCreate(['id' => $paymentInfoData['id']], $paymentInfoData);
            $serviceData['payment_info_id'] = $paymentInfoResponse->id;
        }

        $service = Service::updateOrCreate(['purchase_request_id' => $purchaseRequestId, 'id' => $serviceId], $serviceData);

        $existingInstallments = ServiceInstallment::where('service_id', $service->id)->get();

        $this->updateNumberOfInstallments($existingInstallments, $serviceInstallmentsData);

        foreach ($serviceInstallmentsData as $installment) {
            $installment['service_id'] = $service->id;
            ServiceInstallment::updateOrCreate(['id' => $installment['id']], $installment);
        }
    }

    /**
     * @abstract Responsável por criar ou atualizar products.
     * Recomendado executar com o método específico registerProductRequest ou updateProductRequest
     */
    private function saveProducts(int $purchaseRequestId, array $data)
    {
        $productData = $data['product'];
        $productInstallmentsData = $productData['product_installments'] ?? [];
        $paymentInfoData = $productData['payment_info'] ?? [];

        if (!empty(array_filter($paymentInfoData))) {
            $paymentInfoResponse = PaymentInfo::updateOrCreate(['id' => $paymentInfoData['id']], $paymentInfoData);
            $productData['payment_info_id'] = $paymentInfoResponse->id;
        }

        $product = Product::updateOrCreate(['purchase_request_id' => $purchaseRequestId], $productData);

        $existingInstallments = ProductInstallment::where('product_id', $product->id)->get();

        $this->updateNumberOfInstallments($existingInstallments, $productInstallmentsData);

        foreach ($productInstallmentsData as $installment) {
            $installment['product_id'] = $product->id;
            ProductInstallment::updateOrCreate(['id' => $installment['id']], $installment);
        }

        $suppliers = array_values($data['purchase_request_products']);

        $idsArray = collect($suppliers)->pluck('products')->map(function ($products) {
            return collect($products)->pluck('id');
        })->flatten()->toArray();

        $existingProductIds = PurchaseRequestProduct::where('purchase_request_id', $purchaseRequestId)->pluck('id')->toArray();

        $productIdsToDelete = array_diff($existingProductIds, $idsArray);

        foreach ($suppliers as $supplier) {
            $supplierId = $supplier['supplier_id'];
            $products = array_values($supplier['products']);

            foreach ($products as $product) {
                $product['supplier_id'] = $supplierId;
                $product['purchase_request_id'] = $purchaseRequestId;
                PurchaseRequestProduct::updateOrCreate(['id' => $product['id']], $product);
            }
        }

        PurchaseRequestProduct::whereIn('id', $productIdsToDelete)->delete();
    }

    /**
     * @abstract Responsável por criar ou atualizar contrato.
     * Recomendado executar com o método específico registerContractRequest ou updateContractRequest
     */
    private function saveContract(int $purchaseRequestId, array $data, ?int $contractId = null)
    {
        $contractData = $data['contract'];

        // caso disabled os campos do form define como null
        $contractsInstallmentsData = $contractData['contract_installments'] ?? [];
        $paymentInfoData = $contractData['payment_info'] ?? [];

        if (!empty(array_filter($paymentInfoData))) {
            $paymentInfoResponse = PaymentInfo::updateOrCreate(['id' => $paymentInfoData['id']], $paymentInfoData);
            $contractData['payment_info_id'] = $paymentInfoResponse->id;
        }

        $contract = Contract::updateOrCreate(['purchase_request_id' => $purchaseRequestId, 'id' => $contractId], $contractData);
        $existingInstallments = ContractInstallment::where('contract_id', $contract->id)->get();

        $this->updateNumberOfInstallments($existingInstallments, $contractsInstallmentsData);

        foreach ($contractsInstallmentsData as $installment) {
            $installment['contract_id'] = $contract->id;
            ContractInstallment::updateOrCreate(['id' => $installment['id']], $installment);
        }
    }

    /**
     * Deleta registros remanescentes (se houver) ao atualizar número de parcelas
     *
     * @param $existingInstallments é uma ocorrência do Model Installment
     */
    private function updateNumberOfInstallments($existingInstallments, ?array $installmentsData)
    {
        if (count($existingInstallments) > count($installmentsData)) {
            $installmentsToDelete = $existingInstallments->slice(count($installmentsData));
            foreach ($installmentsToDelete as $installment) {
                $installment->delete();
            }
        }
    }
}
