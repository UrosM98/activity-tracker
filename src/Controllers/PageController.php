<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\BaseController;
use App\Core\Request;
use App\Repositories\EventRepository;
use App\Support\Csrf;
use App\Support\EventAction;

class PageController extends BaseController
{
    public function __construct(
        private readonly EventRepository $events = new EventRepository(),
    ) {
    }

    public function pageA(Request $request): void
    {
        $this->requireAuth();
        $userId = (int) Auth::id();

    if (!Auth::isAdmin()) {
        $this->events->log(EventAction::ViewPage, 'A', $userId);
        }

        $alreadyBought = Auth::isAdmin()
            ? !empty($_SESSION['admin_bought'])
            : $this->events->userClickedBuyCow($userId);

        $this->view('pages/pageA', 
        [
        'alreadyBought' => $alreadyBought,
        ], 'Page A');
    }

    public function buy(Request $request): void
    {
            $this->requireAuth();

        if (!Csrf::check($request->input('_token'))) {
            $this->redirect('/page-a');
        }

        if (Auth::isAdmin()) {
            $_SESSION['admin_bought'] = true;
        } else {
            $this->events->log(EventAction::ButtonClick, 'buyCow', (int) Auth::id());
        }

        $this->redirect('/page-a');
    }


    public function pageB(Request $request): void
    {
        $this->requireAuth();

        if (!Auth::isAdmin()) {
            $this->events->log(EventAction::ViewPage, 'B', (int) Auth::id());
        }

        $this->view('pages/pageB', [], 'Page B');
    }

    public function download(Request $request): void
    {
        $this->requireAuth();

        if (!Csrf::check($request->input('_token'))) {
            $this->redirect('/page-b');
        }

        if (!Auth::isAdmin()) {
            $this->events->log(EventAction::ButtonClick, 'download', (int) Auth::id());
        }

        $file = dirname(__DIR__, 2) . '/static/storage/downloads/report.exe';
        if (!is_file($file)) {
            http_response_code(404);
            echo 'Download file not found.';
            return;
        }

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="report.exe"');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    }
}