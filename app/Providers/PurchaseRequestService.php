<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\ServiceInstallment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use App\Models\{Contract, ContractInstallment, CostCenterApportionment, PaymentInfo, PurchaseRequest, PurchaseRequestFile, PurchaseRequestProduct, Service};

class PurchaseRequestService extends ServiceProvider
{
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
    public function registerPurchaseRequest(array $data)
    {
        return DB::transaction(function () use ($data) {
            $data['user_id'] = auth()->user()->id;
            $purchaseRequest = PurchaseRequest::create($data);

            $this->saveCostCenterApportionment($purchaseRequest->id, $data);
            $this->savePurchaseRequestFile($purchaseRequest->id, $data);

            return $purchaseRequest;
        });
    }

    /**
     * @return mixed Retorna solicitação criada.
     * @abstract Cria solicitação de serviço.
     * Executa método registerPurchaseRequest para criar entidade de solicitação e método saveService para salvar serviço.
     */
    public function registerServiceRequest(array $data)
    {
        return DB::transaction(function () use ($data) {
            $purchaseRequest = $this->registerPurchaseRequest($data);
            $this->saveService($purchaseRequest->id, $data);

            return $purchaseRequest;
        });
    }

    /**
     * @return mixed Retorna solicitação criada.
     * @abstract Cria solicitação de contrato.
     * Executa método registerPurchaseRequest para criar entidade de solicitação e método saveContract para salvar contrato.
     */
    public function registerContractRequest(array $data)
    {
        return DB::transaction(function () use ($data) {
            $purchaseRequest = $this->registerPurchaseRequest($data);
            $this->saveContract($purchaseRequest->id, $data);

            return $purchaseRequest;
        });
    }

    /**
     * @return mixed Retorna solicitação criada.
     * @abstract Cria solicitação de produto(s).
     * Executa método registerPurchaseRequest para criar entidade de solicitação e método saveProduct para salvar produto(s).
     */
    public function registerProductRequest(array $data)
    {
        return DB::transaction(function () use ($data) {
            $purchaseRequest = $this->registerPurchaseRequest($data);
            $this->saveProducts($purchaseRequest->id, $data);

            return $purchaseRequest;
        });
    }

    /**
     * @abstract Atualiza apenas entidade solicitação com relação do rateio e arquivo/link.
     * Deve ser chamada pelos métodos específicios de serviço, contrato ou produtos.
     */
    public function updatePurchaseRequest(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $purchaseRequest = PurchaseRequest::find($id);
            $purchaseRequest->updated_by = auth()->user()->id;
            $purchaseRequest->fill($data);
            $purchaseRequest->save();

            $this->saveCostCenterApportionment($purchaseRequest->id, $data);
            $this->savePurchaseRequestFile($purchaseRequest->id, $data);

            return $purchaseRequest;
        });
    }

    /**
     * @abstract Atualiza solicitação de serviço.
     * Executa método updatePurchaseRequest para atualizar entidade de solicitação e método saveService para atualizar serviço.
     */
    public function updateServiceRequest(int $id, array $data): void
    {
        DB::transaction(function () use ($id, $data) {
            $purchaseRequest = $this->updatePurchaseRequest($id, $data);
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
    public function updateContractRequest(int $id, array $data)
    {
        DB::transaction(function () use ($id, $data) {
            $purchaseRequest = $this->updatePurchaseRequest($id, $data);
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
    private function saveCostCenterApportionment(int $purchaseRequestId, array $data): void
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
    private function savePurchaseRequestFile(int $purchaseRequestId, array $data): void
    {
        $purchaseRequestFile = $data['purchase_request_files'];

        if (!$purchaseRequestFile['path']) {
            return;
        }
        $purchaseRequestFile['purchase_request_id'] = $purchaseRequestId;
        $purchaseRequestFile['updated_by'] = auth()->user()->id;
        PurchaseRequestFile::updateOrCreate(['purchase_request_id' => $purchaseRequestId], $purchaseRequestFile);
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
        $supplierId = $serviceData['supplier_id'] ?? null;
        $serviceInstallmentsData = $serviceData['service_installments'] ?? [];
        $paymentInfoData = $serviceData['payment_info'] ?? null;

        $serviceData['purchase_request_id'] = $purchaseRequestId;
        $serviceData['updated_by'] = auth()->user()->id;

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
    private function saveProducts(int $purchaseRequestId, array $data): void
    {
        if (!isset($data['type']) && $data['type'] !== "product") {
            return;
        }

        $suppliers = $data['purchase_request_products'];

        foreach ($suppliers as $supplier) {
            $supplierId = $supplier['supplier_id'];
            $products = $supplier['products'];

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
    private function saveContract(int $purchaseRequestId, array $data): void
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

        $existingInstallments = ServiceInstallment::where('service_id', $contract->id)->get();

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
    private function updateNumberOfInstallments($existingInstallments, array $installmentsData): void
    {
        if (count($existingInstallments) > count($installmentsData)) {
            $installmentsToDelete = $existingInstallments->slice(count($installmentsData));
            foreach ($installmentsToDelete as $installment) {
                $installment->delete();
            }
        }
    }
}
