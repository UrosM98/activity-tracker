<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\Request;
use App\Repositories\EventRepository;
use App\Repositories\UserRepository;
use App\Support\EventAction;

class StatController extends BaseController
{
    public function __construct(
        private readonly EventRepository $events = new EventRepository(),
        private readonly UserRepository $users = new UserRepository(),
    ) {
    }

    public function statView(Request $request): void
    {
        $this->requireAdmin();

        $filters = [
            'date'    => $request->input('date'),
            'user_id' => $request->input('user_id'),
            'action'  => $request->input('action'),
        ];

        $this->view('stat/statView', [
            'events'  => $this->events->filter($filters),
            'users'   => $this->users->all(),
            'actions' => EventAction::options(),
            'filters' => $filters,
        ], 'User activity');
    }
}