<?php

namespace Tests;

use App\Support\ReportAggregator;
use PHPUnit\Framework\TestCase;

final class ReportAggregatorTest extends TestCase
{
    private function sampleRows(): array
    {
        return [
            ['day' => '2026-01-01', 'views_a' => 3, 'views_b' => 1, 'buy_cow' => 1, 'downloads' => 0],
            ['day' => '2026-01-02', 'views_a' => 2, 'views_b' => 4, 'buy_cow' => 0, 'downloads' => 2],
        ];
    }

    public function testChartSeriesSplitsColumnsIntoSeparateLists(): void
    {
        $series = ReportAggregator::toChartSeries($this->sampleRows());

        $this->assertSame(['2026-01-01', '2026-01-02'], $series['labels']);
        $this->assertSame([3, 2], $series['views_a']);
        $this->assertSame([0, 2], $series['downloads']);
    }

    public function testTotalsSumsEachColumn(): void
    {
        $totals = ReportAggregator::totals($this->sampleRows());

        $this->assertSame(5, $totals['views_a']);
        $this->assertSame(5, $totals['views_b']);
        $this->assertSame(1, $totals['buy_cow']);
        $this->assertSame(2, $totals['downloads']);
    }

    public function testEmptyInputProducesEmptyResult(): void
    {
        $this->assertSame([], ReportAggregator::toChartSeries([])['labels']);
        $this->assertSame(
            ['views_a' => 0, 'views_b' => 0, 'buy_cow' => 0, 'downloads' => 0],
            ReportAggregator::totals([])
        );
    }
}