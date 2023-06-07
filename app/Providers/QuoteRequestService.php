<?php

namespace App\Providers;

use App\Models\CostCenterApportionment;
use App\Models\PurchaseQuote;
use App\Models\QuoteRequest;
use App\Models\QuoteRequestFile;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class QuoteRequestService extends ServiceProvider
{
    /**
     * @return mixed Retorna solicitações de cotações/compras com suas relações, exceto deletados.
     */
    public function quoteRequests()
    {
        return QuoteRequest::with([
            'purchaseQuote', 'user', 'user.person', 'quoteRequestFile',
            'costCenterApportionment', 'costCenterApportionment.costCenter', 'costCenterApportionment.costCenter.company',
            'deletedByUser', 'updatedByUser'
        ])->whereNull('deleted_at')->get();
    }

    public function quoteRequestsByUser(int $id = null)
    {
        $id = $id ?? auth()->user()->id;
        return QuoteRequest::with([
            'purchaseQuote', 'user', 'user.person', 'quoteRequestFile',
            'costCenterApportionment', 'costCenterApportionment.costCenter', 'costCenterApportionment.costCenter.company',
            'deletedByUser', 'updatedByUser'
        ])->whereNull('deleted_at')->where('user_id', $id)->get();
    }

    public function quoteRequestById(int $id)
    {
        return QuoteRequest::with([
            'purchaseQuote', 'user', 'user.person', 'quoteRequestFile',
            'costCenterApportionment', 'costCenterApportionment.costCenter', 'costCenterApportionment.costCenter.company',
            'deletedByUser', 'updatedByUser'
        ])->whereNull('deleted_at')->where('id', $id)->first();
    }

    public function registerQuoteRequest(array $data): void
    {
        DB::transaction(function () use ($data) {
            $data['user_id'] = auth()->user()->id;
            $quoteRequest = QuoteRequest::create($data);
            $this->saveCostCenterApportionment($quoteRequest->id, $data);
            $this->saveQuoteRequestFile($quoteRequest->id, $data);
            $this->createPurchaseQuote($quoteRequest, $data);
        });
    }

    public function updateQuoteRequest(int $id, array $data)
    {
        DB::transaction(function () use ($id, $data) {
            $quoteRequest = QuoteRequest::find($id);
            $quoteRequest->updated_by = auth()->user()->id;
            $quoteRequest->fill($data);
            $quoteRequest->save();

            $this->saveCostCenterApportionment($quoteRequest->id, $data);
            $this->saveQuoteRequestFile($quoteRequest->id, $data);
        });
    }

    public function deleteQuoteRequest(int $id)
    {
        $quoteRequest = QuoteRequest::find($id);
        $quoteRequest->deleted_at = Carbon::now();
        $quoteRequest->deleted_by = auth()->user()->id;
        $quoteRequest->save();
    }

    private function createPurchaseQuote(object $quoteRequest, array $data)
    {
        if ((bool)$data['isSaveAndQuote']) {
            echo '<pre>';
            echo "É salvar e cotar: input hidden input[name='isSaveAndQuote'] enviado com valor 1 <br>";
            var_dump($data['isSaveAndQuote']);
            echo "Verifique private function createPurchaseQuote em QuoteRequestService <br>";
            echo "É necessário adicionar modificar o banco de dados <br> Remover quantity e anexar supplier_id em outra tabela";
            echo '</pre>';
            die;
        }

        if ((bool)$data['isSaveAndQuote']) {
            /**
             * Salvar e cotar acontece apenas quando é cotado pelo usuário, 
             * por isso é obrigatório existir descrição. 
             * (Remover esse comentário assim que concluído etapa de cotação)
             */
            if ($quoteRequest->description) {
                $purchaseQuoteData = ['quote_request_id' => $quoteRequest->id];
                PurchaseQuote::create($purchaseQuoteData);
            } else {
                throw new Exception('Só é possível salvar e cotar quando existir descrição na solicitação de compra/serviço');
            }
        }
    }

    private function saveCostCenterApportionment(int $quoteRequestId, array $data): void
    {
        $apportionmentData = $data['cost_center_apportionments'];
        $apportionmentData['quote_request_id'] = $quoteRequestId;
        $apportionmentData['updated_by'] = auth()->user()->id;
        CostCenterApportionment::updateOrCreate(['quote_request_id' => $quoteRequestId], $apportionmentData);
    }
    private function saveQuoteRequestFile(int $quoteRequestId, array $data): void
    {
        $quoteRequestFile = $data['quote_request_files'];
        if (!$quoteRequestFile['path']) return;
        $quoteRequestFile['quote_request_id'] = $quoteRequestId;
        $quoteRequestFile['updated_by'] = auth()->user()->id;
        QuoteRequestFile::updateOrCreate(['quote_request_id' => $quoteRequestId], $quoteRequestFile);
    }
}
