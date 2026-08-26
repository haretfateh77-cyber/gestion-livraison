<?php

namespace App\Http\Controllers;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('notifications.index', compact('notifications'));
    }

    public function lire(Notification $notification)
    {
        abort_unless($notification->user_id === auth()->id(), 403);

        $notification->update([
            'lu' => true,
        ]);

        return back()->with('success', 'Notification marquée comme lue.');
    }

    public function toutLire()
    {
        Notification::where('user_id', auth()->id())
            ->where('lu', false)
            ->update([
                'lu' => true,
            ]);

        return back()->with('success', 'Toutes les notifications ont été lues.');
    }
}