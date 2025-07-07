<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use App\Services\NotificationService;

class GenerateTestNotifications extends Command
{
    protected $signature = 'test:notifications';
    protected $description = 'Generate test notifications for development';

    public function handle()
    {
        $users = User::all();
        $posts = Post::all();

        if ($users->count() < 2 || $posts->count() < 1) {
            $this->error('Need at least 2 users and 1 post to generate test notifications');
            return;
        }

        $user1 = $users->first();
        $user2 = $users->skip(1)->first();
        $post = $posts->first();

        $notificationService = new NotificationService();

        // Create a like notification
        $like = Like::firstOrCreate([
            'user_id' => $user2->id,
            'post_id' => $post->id
        ]);

        if ($like->wasRecentlyCreated) {
            $notificationService->createLikeNotification($user2, $post);
            $this->info("Created like notification: {$user2->name} liked {$post->user->name}'s post");
        }

        // Create a comment notification
        $commentContent = 'Great post! This is a test comment for notifications.';
        $comment = Comment::create([
            'user_id' => $user2->id,
            'post_id' => $post->id,
            'content' => $commentContent
        ]);

        $notificationService->createCommentNotification($user2, $post, $commentContent);
        $this->info("Created comment notification: {$user2->name} commented on {$post->user->name}'s post");

        $totalNotifications = \App\Models\Notification::count();
        $this->info("Total notifications in database: {$totalNotifications}");

        return 0;
    }
}
