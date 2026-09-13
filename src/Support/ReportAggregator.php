<?php

declare(strict_types=1);

namespace App\Support;

final class ReportAggregator
{
    public static function toChartSeries(array $rows): array
    {
        $series = [
            'labels'    => [],
            'views_a'   => [],
            'views_b'   => [],
            'buy_cow'   => [],
            'downloads' => [],
        ];

        foreach ($rows as $row) {
            $series['labels'][]    = $row['day'];
            $series['views_a'][]   = (int) $row['views_a'];
            $series['views_b'][]   = (int) $row['views_b'];
            $series['buy_cow'][]   = (int) $row['buy_cow'];
            $series['downloads'][] = (int) $row['downloads'];
        }

        return $series;
    }

    public static function totals(array $rows): array
    {
        $totals = ['views_a' => 0, 'views_b' => 0, 'buy_cow' => 0, 'downloads' => 0];

        foreach ($rows as $row) {
            $totals['views_a']   += (int) $row['views_a'];
            $totals['views_b']   += (int) $row['views_b'];
            $totals['buy_cow']   += (int) $row['buy_cow'];
            $totals['downloads'] += (int) $row['downloads'];
        }

        return $totals;
    }
}