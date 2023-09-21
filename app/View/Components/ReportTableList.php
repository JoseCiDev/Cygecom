<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Services\ReportService;

class ReportTableList extends Component
{
    public function __construct(private ReportService $reportService)
    {
    }

    public function render(): View|Closure|string
    {
        $requestingUsers = $this->reportService->getRequistingUsers();

        return view('components.reports.report-table-list', ['requestingUsers' => $requestingUsers]);
    }
}
