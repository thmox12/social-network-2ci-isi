<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Str;

class NotificationService
{
    /**
     * Create a like notification.
     */
    public function createLikeNotification(User $fromUser, Post $post)
    {
        // Don't notify if user liked their own post
        if ($fromUser->id === $post->user_id) {
            return null;
        }

        // Check if notification already exists to avoid duplicates
        $existingNotification = Notification::where([
            'user_id' => $post->user_id,
            'from_user_id' => $fromUser->id,
            'type' => 'like',
        ])->whereJsonContains('data->post_id', $post->id)->first();

        if ($existingNotification) {
            // Update timestamp and mark as unread
            $existingNotification->update([
                'read_at' => null,
                'created_at' => now()
            ]);
            return $existingNotification;
        }

        return Notification::create([
            'user_id' => $post->user_id,
            'from_user_id' => $fromUser->id,
            'type' => 'like',
            'title' => 'New Like',
            'message' => "{$fromUser->name} liked your post: " . Str::limit($post->title, 50),
            'data' => [
                'post_id' => $post->id,
                'post_title' => $post->title,
            ],
        ]);
    }

    /**
     * Create a comment notification.
     */
    public function createCommentNotification(User $fromUser, Post $post, $commentContent)
    {
        // Don't notify if user commented on their own post
        if ($fromUser->id === $post->user_id) {
            return null;
        }

        return Notification::create([
            'user_id' => $post->user_id,
            'from_user_id' => $fromUser->id,
            'type' => 'comment',
            'title' => 'New Comment',
            'message' => "{$fromUser->name} commented on your post: " . Str::limit($commentContent, 50),
            'data' => [
                'post_id' => $post->id,
                'post_title' => $post->title,
                'comment_preview' => Str::limit($commentContent, 100),
            ],
        ]);
    }

    /**
     * Remove like notification when a like is removed.
     */
    public function removeLikeNotification(User $fromUser, Post $post)
    {
        Notification::where([
            'user_id' => $post->user_id,
            'from_user_id' => $fromUser->id,
            'type' => 'like',
        ])->whereJsonContains('data->post_id', $post->id)->delete();
    }

    /**
     * Get unread notifications count for a user.
     */
    public function getUnreadCount(User $user): int
    {
        return $user->notifications()->unread()->count();
    }

    /**
     * Get recent notifications for a user.
     */
    public function getRecentNotifications(User $user, int $limit = 10)
    {
        return $user->notifications()
            ->with('fromUser')
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead(Notification $notification)
    {
        $notification->markAsRead();
    }

    /**
     * Mark all notifications as read for a user.
     */
    public function markAllAsRead(User $user)
    {
        $user->notifications()->unread()->update(['read_at' => now()]);
    }
}
