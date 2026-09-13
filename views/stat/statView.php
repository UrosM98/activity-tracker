<?php
/** @var array $events */
/** @var array $users */
/** @var array $actions */
/** @var array $filters */

$e = static fn (?string $v): string => htmlspecialchars((string) $v, ENT_QUOTES);
?>
<div class="card">
    <h1>User activity</h1>

    <form method="get" action="/stat" class="filters">
        <div>
            <label for="date">Date</label>
            <input type="date" id="date" name="date" value="<?= $e($filters['date']) ?>">
        </div>
        <div>
            <label for="user_id">User</label>
            <select id="user_id" name="user_id">
                <option value="">All users</option>
                <?php foreach ($users as $u): ?>
                    <option value="<?= (int) $u['id'] ?>" <?= (string) $filters['user_id'] === (string) $u['id'] ? 'selected' : '' ?>>
                        <?= $e($u['email']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="action">Action</label>
            <select id="action" name="action">
                <option value="">All actions</option>
                <?php foreach ($actions as $value => $label): ?>
                    <option value="<?= $e($value) ?>" <?= $filters['action'] === $value ? 'selected' : '' ?>>
                        <?= $e($label) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <button type="submit">Filter</button>
        </div>
    </form>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Date / time</th>
                <th>User</th>
                <th>Action</th>
                <th>Target</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($events === []): ?>
                <tr><td colspan="4">No events match these filters.</td></tr>
            <?php else: ?>
                <?php foreach ($events as $row): ?>
                    <tr>
                        <td><?= $e($row['created_at']) ?></td>
                        <td><?= $e($row['email'] ?? '—') ?></td>
                        <td><?= $e(str_replace('_', ' ', $row['action'])) ?></td>
                        <td><?= $e($row['target'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>