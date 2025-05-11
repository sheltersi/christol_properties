<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Inertia\Inertia;

class NotificationController extends Controller
{
    public function index()
{
    $notifications = auth()->user()->notifications()->paginate(10);
    return Inertia::render('Admin/Notifications', [
        'notifications' => $notifications
    ]);
}

public function markAsRead(DatabaseNotification $notification)
{
    if ($notification->notifiable_id !== auth()->id()) {
        abort(403);
    }

    $notification->markAsRead();

    return redirect()->back();
}

}
