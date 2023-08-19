<?php

namespace App\View\Components;

use App\Enums\PurchaseRequestType;
use App\Models\PurchaseRequestFile;
use App\Models\RequestSuppliesFiles;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RequestFiles extends Component
{
    public function __construct(
        private ?int $purchaseRequestId = null,
        private ?bool $isCopy = false,
        private ?bool $isSupplies = false,
        private ?PurchaseRequestType $purchaseRequestType = null
    ) {
    }

    public function render(): View|Closure|string
    {
        $files = $this->isCopy ? false : PurchaseRequestFile::where(["purchase_request_id" => $this->purchaseRequestId, "deleted_at" => null])->get();

        if ($this->isCopy) {
            $files = false;
        } else if ($this->isSupplies) {
            $files = RequestSuppliesFiles::where(["purchase_request_id" => $this->purchaseRequestId, "deleted_at" => null])->get();
        } else {
            $files = PurchaseRequestFile::where(["purchase_request_id" => $this->purchaseRequestId, "deleted_at" => null])->get();
        }

        $params = [
            'purchaseRequestId' => $this->purchaseRequestId,
            'isSupplies' => $this->isSupplies,
            'purchaseRequestType' => $this->purchaseRequestType,
            'files' =>  $files,
        ];

        return view('components.purchase-request.request-files', $params);
    }
}
