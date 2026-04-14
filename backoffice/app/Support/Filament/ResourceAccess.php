<?php

namespace App\Support\Filament;

use App\Models\User;

class ResourceAccess
{
    public static function user(): ?User
    {
        $user = auth()->user();

        return $user instanceof User ? $user : null;
    }

    public static function adminOnly(): bool
    {
        return static::user()?->isAdmin() ?? false;
    }

    public static function adminOrFinance(): bool
    {
        $user = static::user();

        return $user?->isAdmin() || $user?->isFinance() || false;
    }

    public static function adminOrOwner(): bool
    {
        $user = static::user();

        return $user?->isAdmin() || $user?->isOwner() || false;
    }

    public static function adminFinanceOrOwner(): bool
    {
        $user = static::user();

        return $user?->isAdmin() || $user?->isFinance() || $user?->isOwner() || false;
    }

    public static function readOnlyOwner(): bool
    {
        return static::user()?->isOwner() ?? false;
    }
}
