<?php
/** @var array $rows */
/** @var array $series */
/** @var array $totals */

$e = static fn (?string $v): string => htmlspecialchars((string) $v, ENT_QUOTES);
?>
<div class="card">
    <h1>Reports</h1>
    <canvas id="reportChart" height="120"></canvas>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Page view A</th>
                <th>Page view B</th>
                <th>Click "Buy a cow"</th>
                <th>Click "Download"</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($rows === []): ?>
                <tr><td colspan="5">No activity recorded yet.</td></tr>
            <?php else: ?>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?= $e($row['day']) ?></td>
                        <td><?= (int) $row['views_a'] ?></td>
                        <td><?= (int) $row['views_b'] ?></td>
                        <td><?= (int) $row['buy_cow'] ?></td>
                        <td><?= (int) $row['downloads'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
        <?php if ($rows !== []): ?>
        <tfoot>
            <tr>
                <td>Total</td>
                <td><?= (int) $totals['views_a'] ?></td>
                <td><?= (int) $totals['views_b'] ?></td>
                <td><?= (int) $totals['buy_cow'] ?></td>
                <td><?= (int) $totals['downloads'] ?></td>
            </tr>
        </tfoot>
        <?php endif; ?>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    const series = <?= json_encode($series, JSON_THROW_ON_ERROR) ?>;
    new Chart(document.getElementById('reportChart'), {
        type: 'line',
        data: {
            labels: series.labels,
            datasets: [
                { label: 'Page view A',       data: series.views_a,   borderColor: '#2563eb' },
                { label: 'Page view B',       data: series.views_b,   borderColor: '#059669' },
                { label: 'Click "Buy a cow"', data: series.buy_cow,   borderColor: '#d97706' },
                { label: 'Click "Download"',  data: series.downloads, borderColor: '#dc2626' },
            ],
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } },
        },
    });
</script>