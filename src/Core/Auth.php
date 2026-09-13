<?php

declare(strict_types=1);

namespace App\Core;

final class Auth
{
    public static function login(int $id, string $email, string $role): void
    {
        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id'    => $id,
            'email' => $email,
            'role'  => $role,
        ];
    }

    public static function logout(): void
    {
        $_SESSION = [];
        session_destroy();
    }

    public static function check(): bool
    {
        return isset($_SESSION['user']);
    }

    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public static function id(): ?int
    {
        return $_SESSION['user']['id'] ?? null;
    }

    public static function isAdmin(): bool
    {
        return ($_SESSION['user']['role'] ?? null) === 'admin';
    }
}