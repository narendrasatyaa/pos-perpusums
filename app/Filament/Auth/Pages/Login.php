<?php

namespace App\Filament\Auth\Pages;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Support\Enums\Width;

class Login extends BaseLogin
{
    protected string $view = 'filament.auth.pages.login';

    protected Width | string | null $maxContentWidth = Width::Full;

    public function hasLogo(): bool
    {
        return false;
    }

    public function getHeading(): string | \Illuminate\Contracts\Support\Htmlable | null
    {
        return null;
    }

    public function getSubheading(): string | \Illuminate\Contracts\Support\Htmlable | null
    {
        return null;
    }
}