<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use App\Support\EventAction;
use PDO;

final class EventRepository
{
    private PDO $db;

    public function __construct(?PDO $db = null)
    {
        $this->db = $db ?? Database::connection();
    }

    public function log(EventAction $action, ?string $target = null, ?int $userId = null): void
    {
        $statement = $this->db->prepare(
            'INSERT INTO events (user_id, action, target) VALUES (?, ?, ?)'
        );
        $statement->execute([$userId, $action->value, $target]);
    }

    public function userClickedBuyCow(int $userId): bool
    {
        $statement = $this->db->prepare(
            "SELECT 1 FROM events
                WHERE user_id = ? AND action = 'button_click' AND target = 'buyCow'
            LIMIT 1"
        );
        $statement->execute([$userId]);

        return (bool) $statement->fetchColumn();
    }

    public function filter(array $filters): array
    {
        $where = [];
        $params = [];

        if (!empty($filters['date'])) {
            $where[] = 'DATE(e.created_at) = ?';
            $params[] = $filters['date'];
        }

        if (!empty($filters['user_id'])) {
            $where[] = 'e.user_id = ?';
            $params[] = (int) $filters['user_id'];
        }

        if (!empty($filters['action']) && EventAction::tryFrom($filters['action']) !== null) {
            $where[] = 'e.action = ?';
            $params[] = $filters['action'];
        }

        $sql = 'SELECT e.id, e.created_at, e.action, e.target, u.email
                FROM events e
                LEFT JOIN users u ON u.id = e.user_id';

        if ($where !== []) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }

        $sql .= ' ORDER BY e.created_at DESC LIMIT 500';

        $statement = $this->db->prepare($sql);
        $statement->execute($params);

        return $statement->fetchAll();
    }

    public function dailyReport(): array
    {
        $sql = "SELECT
                    DATE(created_at) AS day,
                    SUM(action = 'view_page'    AND target = 'A')         AS views_a,
                    SUM(action = 'view_page'    AND target = 'B')         AS views_b,
                    SUM(action = 'button_click' AND target = 'buyCow') AS buy_cow,
                    SUM(action = 'button_click' AND target = 'download')  AS downloads
                FROM events
                GROUP BY DATE(created_at)
                ORDER BY day";

        return $this->db->query($sql)->fetchAll();
    }
}