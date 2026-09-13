<?php

declare(strict_types=1);

namespace App\Support;

enum EventAction: string
{
    case Login = 'login';
    case Logout = 'logout';
    case Registration = 'registration';
    case ViewPage = 'view_page';
    case ButtonClick = 'button_click';

    public function label(): string
    {
        return match ($this) {
            self::Login        => 'Login',
            self::Logout       => 'Logout',
            self::Registration => 'Registration',
            self::ViewPage     => 'View page',
            self::ButtonClick  => 'Button click',
        };
    }

    public static function options(): array
    {
        $out = [];
        foreach (self::cases() as $case) {
            $out[$case->value] = $case->label();
        }

        return $out;
    }
}