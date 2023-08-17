<?php

namespace App\View\Components;

use App\Models\PurchaseRequestFile;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RequestFiles extends Component
{
    public function __construct(private ?int $purchaseRequestId = null, private ?bool $isCopy = false)
    {
    }

    public function render(): View|Closure|string
    {
        $params = [];
        if (!$this->isCopy) {
            $params['files'] = PurchaseRequestFile::where(["purchase_request_id" => $this->purchaseRequestId, "deleted_at" => null])->get();
        }
        return view('components.purchase-request.request-files', $params);
    }
}
