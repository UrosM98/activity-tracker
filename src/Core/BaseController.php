<?php

declare(strict_types=1);

namespace App\Core;

abstract class BaseController
{
    protected function view(string $template, array $data = [], string $title = 'Activity Tracker'): void
    {
        extract($data, EXTR_SKIP);
        $viewFile = dirname(__DIR__, 2) . '/views/' . $template . '.php';

        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        require dirname(__DIR__, 2) . '/views/layout.php';
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . $path);
        exit;
    }

    protected function requireAuth(): void
    {
        if (!Auth::check()) {
            $this->redirect('/login');
        }
    }

    protected function requireAdmin(): void
    {
        $this->requireAuth();
        if (!Auth::isAdmin()) {
            http_response_code(403);
            echo '403 Forbidden';
            exit;
        }
    }
}