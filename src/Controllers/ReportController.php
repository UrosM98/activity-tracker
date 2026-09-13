<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\Request;
use App\Repositories\EventRepository;
use App\Support\ReportAggregator;

class ReportController extends BaseController
{
    public function __construct(
        private readonly EventRepository $events = new EventRepository(),
    ) {
    }

    public function reportsView(): void
    {
        $this->requireAdmin();

        $rows = $this->events->dailyReport();

        $this->view('reports/reportsView', [
            'rows'   => $rows,
            'series' => ReportAggregator::toChartSeries($rows),
            'totals' => ReportAggregator::totals($rows),
        ], 'Reports');
    }
}