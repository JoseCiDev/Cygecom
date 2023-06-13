<?php

namespace App\Services;

use App\Models\{PurchaseQuote, QuoteRequest, Supplier};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class QuotationService extends ServiceProvider
{
    public function getAllPurchaseQuotes()
    {
        return PurchaseQuote::all();
    }

    public function registerQuotation(array $data)
    {
        dd($data);
        $hasRequest               = $data['has_request'];
        $costCenterApportionments = $data['cost_center_apportionments'];
        $isService                = $data['is_service'];
        $suppliers                = $data['suppliers'];
        $observation              = $data['observation'];
        $startDate                = $data['start_date'];
        $endDate                  = $data['end_date'];
        $recurrence               = $data['recurrence'];
        $textarea                 = $data['textarea'];

        $quotation                             = new PurchaseQuote();
        $quotation->has_request                = $hasRequest;
        $quotation->cost_center_apportionments = $costCenterApportionments;
        $quotation->is_service                 = $isService;
        $quotation->suppliers                  = $suppliers;
        $quotation->observation                = $observation;
        $quotation->start_date                 = $startDate;
        $quotation->end_date                   = $endDate;
        $quotation->recurrence                 = $recurrence;
        $quotation->textarea                   = $textarea;
        $quotation->save();

        dd($quotation);

        return $quotation;
    }

    public function updatePurchaseQuote(array $data, int $purchaseQuoteId): void
    {
        DB::transaction(function () use ($data, $purchaseQuoteId) {
            $purchaseQuote = $this->getPurchaseQuoteById($purchaseQuoteId);

            $purchaseQuote->quantity = $data['quantity'] ?? $purchaseQuote->quantity;
            $purchaseQuote->status   = $data['status'] ?? $purchaseQuote->status;
            $purchaseQuote->save();
        });
    }

    public function deletePurchaseQuote(int $id): void
    {
        $purchaseQuote             = PurchaseQuote::find($id);
        $purchaseQuote->deleted_at = now();
        $purchaseQuote->deleted_by = auth()->user()->id;
        $purchaseQuote->save();
    }

    public function getQuoteRequestById(int $id): QuoteRequest
    {
        return QuoteRequest::findOrFail($id);
    }

    public function getSupplierById(int $id): Supplier
    {
        return Supplier::findOrFail($id);
    }
}
