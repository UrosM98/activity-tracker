<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\BaseController;
use App\Core\Request;
use App\Repositories\EventRepository;
use App\Repositories\UserRepository;
use App\Support\Csrf;
use App\Support\EventAction;

final class AuthController extends BaseController
{
    public function __construct(
        private readonly UserRepository $users = new UserRepository(),
        private readonly EventRepository $events = new EventRepository(),
    ) {
    }

    public function showLogin(): void
    {
        if (Auth::check()) {
            $this->redirect('/page-a');
        }
        $this->view('auth/login', ['error' => null], 'Login');
    }

    public function login(Request $request): void
{
    if (!Csrf::check($request->input('_token'))) {
        $this->view('auth/login', ['error' => 'Invalid session token, please try again.'], 'Login');
        return;
    }

    $email = (string) $request->input('email', '');
    $password = (string) $request->input('password', '');
    $user = $this->users->findByEmail($email);

    if ($user === null || !password_verify($password, $user['password_hash'])) {
        $this->view('auth/login', ['error' => 'Invalid email or password.'], 'Login');
        return;
    }

    Auth::login((int) $user['id'], $user['email'], $user['role']);
    $this->events->log(EventAction::Login, null, (int) $user['id']);

    $this->redirect('/page-a');
}

    public function showRegister(): void
    {
        if (Auth::check()) {
            $this->redirect('/page-a');
        }
        $this->view('auth/register', ['error' => null], 'Register');
    }

    public function register(Request $request): void
    {
        $email = (string) $request->input('email', '');
        $password = (string) $request->input('password', '');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->view('auth/register', ['error' => 'Please enter a valid email address.'], 'Register');
            return;
        }
        if (strlen($password) < 6) {
            $this->view('auth/register', ['error' => 'Password must have at least 6 character.'], 'Register');
            return;
        }
        if ($this->users->emailExists($email)) {
            $this->view('auth/register', ['error' => 'Already registered email.'], 'Register');
            return;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $userId = $this->users->create($email, $hash, 'user');

        $this->events->log(EventAction::Registration, null, $userId);

        Auth::login($userId, $email, 'user');
        $this->events->log(EventAction::Login, null, $userId);

        $this->redirect('/page-a');
    }

    public function logout(): void
    {
        $userId = Auth::id();
        if ($userId !== null) {
            $this->events->log(EventAction::Logout, null, $userId);
        }
        Auth::logout();
        $this->redirect('/login');
    }
}