<?php

namespace App\View\Components;

use App\Providers\QuoteRequestService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LastQuoteRequestSidebar extends Component
{
    private $quoteRequestService;
    public function __construct(QuoteRequestService $quoteRequestService)
    {
        $this->quoteRequestService = $quoteRequestService;
    }

    public function render(): View|Closure|string
    {
        $lastQuoteRequests = $this->quoteRequestService->lastQuoteRequestsByUserWithDeletes();
        return view('components.quote-request.last-quote-request-sidebar', ['lastQuoteRequests' => $lastQuoteRequests]);
    }
}
