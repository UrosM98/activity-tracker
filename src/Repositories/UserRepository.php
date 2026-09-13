<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use PDO;

final class UserRepository
{
    private PDO $db;

   public function __construct(?PDO $db = null)
{
    $this->db = $db ?? Database::connection();
}

    public function findByEmail(string $email): ?array
    {
        $statement = $this->db->prepare('SELECT id, email, password_hash, role FROM users WHERE email = ?');
        $statement->execute([$email]);
        $row = $statement->fetch();

        return $row ?: null;
    }

    public function emailExists(string $email): bool
    {
        $statement = $this->db->prepare('SELECT 1 FROM users WHERE email = ?');
        $statement->execute([$email]);

        return (bool) $statement->fetchColumn();
    }

    public function create(string $email, string $passwordHash, string $role = 'user'): int
    {
        $statement = $this->db->prepare(
            'INSERT INTO users (email, password_hash, role) VALUES (?, ?, ?)'
        );
        $statement->execute([$email, $passwordHash, $role]);

        return (int) $this->db->lastInsertId();
    }

    public function all(): array
    {
        return $this->db->query('SELECT id, email FROM users ORDER BY email')->fetchAll();
    }
}