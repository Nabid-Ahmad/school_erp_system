<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function markAsRead(Request $request, DatabaseNotification $notification): RedirectResponse
    {
        $this->authorizeNotification($request->user(), $notification);
        $notification->markAsRead();

        return redirect()->back();
    }

    public function markAllAsRead(Request $request): RedirectResponse
    {
        $request->user()->unreadNotifications()->update(['read_at' => now()]);

        return redirect()->back();
    }

    private function authorizeNotification($user, DatabaseNotification $notification): void
    {
        abort_if($notification->notifiable_id !== $user->id, 403);
    }
}
