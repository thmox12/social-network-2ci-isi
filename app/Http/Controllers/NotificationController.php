<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    private NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        $user = Auth::user();
        $notifications = $this->notificationService->getRecentNotifications($user, 20);
        $unreadCount = $this->notificationService->getUnreadCount($user);

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    public function getUnreadCount()
    {
        $count = $this->notificationService->getUnreadCount(Auth::user());

        return response()->json(['count' => $count]);
    }

    public function getRecent()
    {
        $notifications = $this->notificationService->getRecentNotifications(Auth::user(), 10);

        return response()->json([
            'notifications' => $notifications->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'type' => $notification->type,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'from_user' => $notification->fromUser->name,
                    'read' => $notification->isRead(),
                    'created_at' => $notification->created_at->diffForHumans(),
                    'action_url' => $this->getActionUrl($notification),
                ];
            })
        ]);
    }

    public function markAsRead(Notification $notification)
    {
        // Ensure user owns this notification
        if ($notification->user_id !== Auth::id()) {
            return response()->json(['success' => false], 403);
        }

        $this->notificationService->markAsRead($notification);

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        $this->notificationService->markAllAsRead(Auth::user());

        return response()->json(['success' => true]);
    }

    private function getActionUrl(Notification $notification): ?string
    {
        if (isset($notification->data['post_id'])) {
            return route('posts.show', $notification->data['post_id']);
        }

        return null;
    }
}
