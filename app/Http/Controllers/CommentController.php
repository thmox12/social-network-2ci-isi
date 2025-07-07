<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentController extends Controller
{
    use AuthorizesRequests;

    private NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function store(Request $request, Post $post)
    {
        $user = Auth::user();

        // Check if user can view this post (following policy)
        $this->authorize('view', $post);

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = $post->comments()->create([
            'user_id' => $user->id,
            'content' => $request->content,
        ]);

        // Create notification
        $this->notificationService->createCommentNotification($user, $post, $request->content);

        // Load the user relationship for the response
        $comment->load('user');

        return response()->json([
            'success' => true,
            'comment' => [
                'id' => $comment->id,
                'content' => $comment->content,
                'user_name' => $comment->user->name,
                'created_at' => $comment->created_at->diffForHumans(),
                'can_delete' => $comment->user_id === $user->id,
            ],
            'comments_count' => $post->comments()->count(),
            'message' => 'Comment added successfully'
        ]);
    }

    public function destroy(Comment $comment)
    {
        $user = Auth::user();

        // Check if user can delete this comment (only the author or post owner)
        if ($comment->user_id !== $user->id && $comment->post->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to delete this comment'
            ], 403);
        }

        $postId = $comment->post_id;
        $comment->delete();

        $post = Post::find($postId);

        return response()->json([
            'success' => true,
            'comments_count' => $post->comments()->count(),
            'message' => 'Comment deleted successfully'
        ]);
    }
}
