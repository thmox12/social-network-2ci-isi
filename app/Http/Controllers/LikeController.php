<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LikeController extends Controller
{
    use AuthorizesRequests;

    private NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
    public function store(Post $post)
    {
        $user = Auth::user();

        // Check if user can view this post (following policy)
        $this->authorize('view', $post);

        // Check if user has already liked this post
        if ($post->isLikedBy($user)) {
            return response()->json([
                'success' => false,
                'message' => 'You have already liked this post'
            ], 400);
        }

        $like = $post->likes()->create([
            'user_id' => $user->id,
        ]);

        // Create notification
        $this->notificationService->createLikeNotification($user, $post);

        return response()->json([
            'success' => true,
            'liked' => true,
            'likes_count' => $post->likes()->count(),
            'message' => 'Post liked successfully'
        ]);
    }

    public function destroy(Post $post)
    {
        $user = Auth::user();

        // Check if user can view this post (following policy)
        $this->authorize('view', $post);

        $like = $post->likes()->where('user_id', $user->id)->first();

        if (!$like) {
            return response()->json([
                'success' => false,
                'message' => 'You have not liked this post'
            ], 400);
        }

        $like->delete();

        // Remove notification
        $this->notificationService->removeLikeNotification($user, $post);

        return response()->json([
            'success' => true,
            'liked' => false,
            'likes_count' => $post->likes()->count(),
            'message' => 'Like removed successfully'
        ]);
    }
}
