<?php

namespace App\Providers;

use Exception;
use Carbon\Carbon;
use App\Services\S3;
use Illuminate\Http\UploadedFile;
use App\Enums\PurchaseRequestType;
use App\Models\ServiceInstallment;
use Illuminate\Support\Facades\DB;
use App\Enums\PurchaseRequestStatus;
use Illuminate\Support\ServiceProvider;
use App\Models\{Contract, ContractInstallment, CostCenterApportionment, PaymentInfo, PurchaseRequest, PurchaseRequestFile, PurchaseRequestProduct, Service};

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
            'service',
            'service.paymentInfo',
            'purchaseRequestProduct',
            'purchaseRequestProduct.category',
            'contract',
            'contract.installments',
        ]);
    }

    /**
     * @return mixed Retorna todas solicitações com suas relações, exceto deletados.
     */
    public function purchaseRequests()
    {
        return PurchaseRequest::with([
            'user.person.costCenter',
            'purchaseRequestFile',
            'costCenterApportionment.costCenter.company',
            'deletedByUser',
            'updatedByUser',
            'service',
            'service.paymentInfo',
            'purchaseRequestProduct',
            'purchaseRequestProduct.category',
            'contract',
            'contract.installments',
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
            'purchaseRequestFile',
            'costCenterApportionment.costCenter.company',
            'deletedByUser',
            'updatedByUser',
            'service',
            'service.paymentInfo',
            'purchaseRequestProduct',
            'purchaseRequestProduct.category',
            'contract',
            'contract.installments',

        ])->whereNull('deleted_at')->where('user_id', $id)->get();
    }

    /**
     * @return mixed Pelo status da solicitação retorna todas com suas relações, exceto deletadas.
     */
    public function purchaseRequestsByStatus(PurchaseRequestStatus $status)
    {
        return PurchaseRequest::with([
            'user.person.costCenter',
            'purchaseRequestFile',
            'costCenterApportionment.costCenter.company',
            'deletedByUser',
            'updatedByUser',
            'service',
            'service.paymentInfo',
            'purchaseRequestProduct',
            'purchaseRequestProduct.category',
            'contract',
            'contract.installments',

        ])->whereNull('deleted_at')->where('status', $status->value);
    }

    /**
     * @return mixed Pelo id retorna solicitação com suas relações, exceto deletada.
     */
    public function purchaseRequestById(int $id)
    {
        return PurchaseRequest::with([
            'user.person.costCenter',
            'purchaseRequestFile',
            'costCenterApportionment.costCenter.company',
            'deletedByUser',
            'updatedByUser',
            'service',
            'service.paymentInfo',
            'purchaseRequestProduct',
            'purchaseRequestProduct.category',
            'contract',
            'contract.installments',
        ])->whereNull('deleted_at')->where('id', $id)->first();
    }

    /**
     * @abstract Cria apenas entidade solicitação com relação do rateio e arquivo/link.
     * Deve ser chamada pelos métodos específicios de serviço, contrato ou produtos.
     */
    public function registerPurchaseRequest(array $data,  UploadedFile | array | null $files)
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
    public function registerServiceRequest(array $data,  UploadedFile | array | null $files)
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
    public function registerContractRequest(array $data,  UploadedFile | array | null $files)
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
    public function registerProductRequest(array $data,  UploadedFile | array | null $files = null)
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
    public function updatePurchaseRequest(int $id, array $data, bool $isSuppliesUpdate = false, UploadedFile | array | null $files = null)
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

    private function uploadFilesToS3(UploadedFile | array $files, PurchaseRequestType $purchcaseRequestType, int $requestId, array $originalNames): void
    {
        $type = 'request-' . $purchcaseRequestType->value;

        $uploadedFilesData = [];

        foreach ($files as $index => $file) {
            $uploadedFilesData[] = [
                'file' => $file,
                'original_name' => $originalNames[$index], // Pegar o nome original do arquivo a partir do array
            ];
        }

        $uploadFiles = S3::sendFiles($files, $type, $requestId);

        if (!$uploadFiles->success) {
            $msg = $uploadFiles->exception;
            throw new Exception($msg);
        }
        foreach ($uploadFiles->urls_bucket as $index => $filePath) {
            $this->savePurchaseRequestFile($requestId, $filePath, $originalNames[$index]);
        }
    }

    /**
     * @abstract Atualiza solicitação de serviço.
     * Executa método updatePurchaseRequest para atualizar entidade de solicitação e método saveService para atualizar serviço.
     */
    public function updateServiceRequest(int $id, array $data, UploadedFile | array | null  $files)
    {
        DB::transaction(function () use ($id, $data, $files) {
            $purchaseRequest = $this->updatePurchaseRequest($id, $data, false, $files);
            $this->saveService($purchaseRequest->id, $data);
        });
    }

    /**
     * @abstract Atualiza solicitação de produto(s).
     * Executa método updatePurchaseRequest para atualizar entidade de solicitação e método saveProduct para atualizar produto(s).
     */
    public function updateProductRequest(int $id, array $data)
    {
        DB::transaction(function () use ($id, $data) {
            $purchaseRequest = $this->updatePurchaseRequest($id, $data);
            $this->saveProducts($purchaseRequest->id, $data);
        });
    }

    /**
     * @abstract Atualiza solicitação de contrato.
     * Executa método updatePurchaseRequest para atualizar entidade de solicitação e método saveContract para atualizar contrato.
     */
    public function updateContractRequest(int $id, array $data, UploadedFile | array | null  $files)
    {
        DB::transaction(function () use ($id, $data, $files) {
            $purchaseRequest = $this->updatePurchaseRequest($id, $data, false, $files);
            $this->saveContract($purchaseRequest->id, $data);
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
     * @abstract Responsável por criar ou atualizar service.
     * Recomendado executar com o método específico registerServiceRequest ou updateServiceRequest
     */
    private function saveService(int $purchaseRequestId, array $data): void
    {
        if (!isset($data['type']) && $data['type'] !== "service") {
            return;
        }

        $serviceData = $data['service'];

        // caso disabled os campos do form define como null
        $serviceInstallmentsData = $serviceData['service_installments'] ?? null;
        $paymentInfoData = $serviceData['payment_info'] ?? null;
        $supplierId = $serviceData['supplier_id'] ?? null;

        if (count($paymentInfoData) > 0) {
            $paymentInfoResponse = PaymentInfo::updateOrCreate(['id' => $paymentInfoData['id']], $paymentInfoData);
            $serviceData['payment_info_id'] = $paymentInfoResponse->id;
        }

        $service = Service::updateOrCreate(['purchase_request_id' => $purchaseRequestId, 'supplier_id' => $supplierId], $serviceData);

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
        if (!isset($data['type']) && $data['type'] !== "product") {
            return;
        }

        $suppliers = array_values($data['purchase_request_products']);

        foreach ($suppliers as $supplier) {
            $supplierId = $supplier['supplier_id'];
            $products = array_values($supplier['products']);

            foreach ($products as $product) {
                $product['supplier_id'] = $supplierId;
                $product['purchase_request_id'] = $purchaseRequestId;
                PurchaseRequestProduct::updateOrCreate(['id' => $product['id']], $product);
            }
        }
    }

    /**
     * @abstract Responsável por criar ou atualizar contrato.
     * Recomendado executar com o método específico registerContractRequest ou updateContractRequest
     */
    private function saveContract(int $purchaseRequestId, array $data)
    {
        if (!isset($data['type']) && $data['type'] !== "contract") {
            return;
        }

        $contractData = $data['contract'];

        // caso disabled os campos do form define como null
        $contractsInstallmentsData = $contractData['contract_installments'] ?? null;
        $paymentInfoData = $contractData['payment_info'] ?? null;
        $supplierId = $contractData['supplier_id'] ?? null;

        if (count($paymentInfoData) > 0) {
            $paymentInfoResponse = PaymentInfo::updateOrCreate(['id' => $paymentInfoData['id']], $paymentInfoData);
            $contractData['payment_info_id'] = $paymentInfoResponse->id;
        }

        $contract = Contract::updateOrCreate(['purchase_request_id' => $purchaseRequestId, 'supplier_id' => $supplierId], $contractData);

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
    private function updateNumberOfInstallments($existingInstallments, array $installmentsData)
    {
        if (count($existingInstallments) > count($installmentsData)) {
            $installmentsToDelete = $existingInstallments->slice(count($installmentsData));
            foreach ($installmentsToDelete as $installment) {
                $installment->delete();
            }
        }
    }
}
