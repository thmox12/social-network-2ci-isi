{{-- resources/views/posts/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Post Details') }}
            </h2>
            <a href="{{ route('posts.index') }}"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Posts
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $post->title }}</h1>
                                <div class="flex items-center space-x-4 text-sm text-gray-600">
                                    <span>by {{ $post->user->name }}</span>
                                    <span>{{ $post->created_at->format('M j, Y \a\t g:i A') }}</span>
                                    @if($post->is_ai_generated)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                        </svg>
                                        AI Generated
                                    </span>
                                    @endif
                                </div>
                            </div>

                            @can('update', $post)
                            <div class="flex space-x-2">
                                <a href="{{ route('posts.edit', $post) }}"
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('posts.destroy', $post) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm"
                                        onclick="return confirm('Are you sure you want to delete this post?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                            @endcan
                        </div>
                    </div>

                    <div class="prose max-w-none">
                        <div class="text-gray-700 leading-relaxed text-base space-y-4">
                            <div class="text-gray-700 leading-relaxed text-base space-y-4">
                                {!! App\Utils\ContentFormatter::formatContent($post->content) !!}
                            </div>
                        </div>
                    </div>

                    <!-- Like and Comment Actions -->
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-6">
                                <!-- Like Button -->
                                <button onclick="toggleLike({{ $post->id }})"
                                        id="like-btn-{{ $post->id }}"
                                        class="flex items-center space-x-2 text-slate-500 hover:text-red-600 transition-colors {{ $post->isLikedBy(auth()->user()) ? 'text-red-600' : '' }}">
                                    <svg class="w-6 h-6" fill="{{ $post->isLikedBy(auth()->user()) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                    <span class="font-medium" id="like-count-{{ $post->id }}">{{ $post->likes->count() }}</span>
                                    <span class="text-sm">{{ $post->likes->count() === 1 ? 'Like' : 'Likes' }}</span>
                                </button>

                                <!-- Comment Count -->
                                <div class="flex items-center space-x-2 text-slate-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                    <span class="font-medium" id="comment-count-{{ $post->id }}">{{ $post->comments->count() }}</span>
                                    <span class="text-sm">{{ $post->comments->count() === 1 ? 'Comment' : 'Comments' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Comments Section -->
                        <div>
                            <!-- Comment Form -->
                            <form onsubmit="submitComment(event, {{ $post->id }})" class="mb-6">
                                <div class="flex space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full flex items-center justify-center text-white font-medium">
                                        {{ auth()->user()->name[0] }}
                                    </div>
                                    <div class="flex-1">
                                        <textarea name="content"
                                                id="comment-input-{{ $post->id }}"
                                                placeholder="Write a comment..."
                                                rows="3"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"></textarea>
                                        <div class="flex justify-end mt-3">
                                            <button type="submit"
                                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg">
                                                Post Comment
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <!-- Comments List -->
                            <div id="comments-list-{{ $post->id }}" class="space-y-4">
                                @forelse($post->comments()->orderBy('created_at', 'desc')->get() as $comment)
                                    <div class="flex space-x-3" id="comment-{{ $comment->id }}">
                                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full flex items-center justify-center text-white font-medium">
                                            {{ $comment->user->name[0] }}
                                        </div>
                                        <div class="flex-1">
                                            <div class="bg-gray-50 rounded-lg px-4 py-3">
                                                <div class="flex items-center justify-between mb-2">
                                                    <span class="font-medium text-gray-900">{{ $comment->user->name }}</span>
                                                    <div class="flex items-center space-x-3">
                                                        <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                                        @if($comment->user_id === auth()->id() || $post->user_id === auth()->id())
                                                            <button onclick="deleteComment({{ $comment->id }})"
                                                                    class="text-sm text-red-600 hover:text-red-800">
                                                                Delete
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                                <p class="text-gray-700">{{ $comment->content }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-8 text-gray-500">
                                        <p>No comments yet. Be the first to comment!</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    @if($post->updated_at != $post->created_at)
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <p class="text-sm text-gray-500">
                            Last updated: {{ $post->updated_at->format('M j, Y \a\t g:i A') }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .prose p {
            margin-bottom: 1rem;
        }

        .prose p:last-child {
            margin-bottom: 0;
        }

        .prose strong {
            font-weight: 600;
            color: #1F2937;
        }

        .prose em {
            font-style: italic;
            color: #6B7280;
        }
    </style>

    <script>
        // Toggle Like Function
        async function toggleLike(postId) {
            const likeBtn = document.getElementById(`like-btn-${postId}`);
            const likeCount = document.getElementById(`like-count-${postId}`);
            const heartIcon = likeBtn.querySelector('svg');

            try {
                const isLiked = likeBtn.classList.contains('text-red-600');
                const url = isLiked ? `/posts/${postId}/like` : `/posts/${postId}/like`;
                const method = isLiked ? 'DELETE' : 'POST';

                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Update UI
                    if (data.liked) {
                        likeBtn.classList.add('text-red-600');
                        likeBtn.classList.remove('text-slate-500');
                        heartIcon.setAttribute('fill', 'currentColor');
                    } else {
                        likeBtn.classList.remove('text-red-600');
                        likeBtn.classList.add('text-slate-500');
                        heartIcon.setAttribute('fill', 'none');
                    }

                    likeCount.textContent = data.likes_count;
                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Something went wrong. Please try again.');
            }
        }

        // Submit Comment Function
        async function submitComment(event, postId) {
            event.preventDefault();

            const commentInput = document.getElementById(`comment-input-${postId}`);
            const commentsList = document.getElementById(`comments-list-${postId}`);
            const commentCount = document.getElementById(`comment-count-${postId}`);
            const content = commentInput.value.trim();

            if (!content) {
                alert('Please enter a comment');
                return;
            }

            try {
                const response = await fetch(`/posts/${postId}/comments`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ content: content })
                });

                const data = await response.json();

                if (data.success) {
                    // Create new comment element
                    const commentHtml = `
                        <div class="flex space-x-3" id="comment-${data.comment.id}">
                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full flex items-center justify-center text-white font-medium">
                                ${data.comment.user_name.charAt(0).toUpperCase()}
                            </div>
                            <div class="flex-1">
                                <div class="bg-gray-50 rounded-lg px-4 py-3">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="font-medium text-gray-900">${data.comment.user_name}</span>
                                        <div class="flex items-center space-x-3">
                                            <span class="text-sm text-gray-500">${data.comment.created_at}</span>
                                            ${data.comment.can_delete ? `<button onclick="deleteComment(${data.comment.id})" class="text-sm text-red-600 hover:text-red-800">Delete</button>` : ''}
                                        </div>
                                    </div>
                                    <p class="text-gray-700">${data.comment.content}</p>
                                </div>
                            </div>
                        </div>
                    `;

                    // Add comment to the top of the list
                    commentsList.insertAdjacentHTML('afterbegin', commentHtml);

                    // Update comment count
                    commentCount.textContent = data.comments_count;

                    // Clear input
                    commentInput.value = '';
                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Something went wrong. Please try again.');
            }
        }

        // Delete Comment Function
        async function deleteComment(commentId) {
            if (!confirm('Are you sure you want to delete this comment?')) {
                return;
            }

            try {
                const response = await fetch(`/comments/${commentId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Remove comment from DOM
                    const commentElement = document.getElementById(`comment-${commentId}`);
                    if (commentElement) {
                        commentElement.remove();
                    }

                    // Update comment count
                    const commentCount = document.querySelector('[id^="comment-count-"]');
                    if (commentCount) {
                        commentCount.textContent = data.comments_count;
                    }
                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Something went wrong. Please try again.');
            }
        }
    </script>
</x-app-layout>
