<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\SchoolActivity;

class NotificationService
{
    /**
     * Send a database notification to every admin user.
     */
    public static function toAdmins(string $title, string $message, ?string $url = null): void
    {
        User::query()
            ->where('role', 'admin')
            ->get()
            ->each(fn (User $admin) => $admin->notify(new SchoolActivity($title, $message, $url)));
    }
}
