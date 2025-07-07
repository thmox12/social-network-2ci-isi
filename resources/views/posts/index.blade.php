{{-- resources/views/posts/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Social Feed</h2>
                <p class="text-slate-600 mt-1">Stay connected with your network's latest updates</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('posts.create') }}" class="btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Create Post
                </a>
                <a href="{{ route('ai-posts.create') }}" class="btn-ai">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                    AI Generate
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if($posts->count() > 0)
                <div class="space-y-6">
                    @foreach($posts as $post)
                        <article class="card group hover:shadow-lg transition-all duration-300">
                            <div class="card-body">
                                <!-- Post Header -->
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold text-lg">
                                            {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="flex items-center space-x-2">
                                                <h3 class="font-semibold text-slate-900">{{ $post->user->name }}</h3>
                                                @if($post->is_ai_generated)
                                                    <span class="badge badge-ai">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                                        </svg>
                                                        AI Generated
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="flex items-center text-sm text-slate-500">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                {{ $post->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>

                                    @can('update', $post)
                                        <div class="relative" x-data="{ open: false }">
                                            <button @click="open = !open"
                                                    class="p-2 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-100 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                                </svg>
                                            </button>
                                            <div x-show="open"
                                                 @click.away="open = false"
                                                 x-transition:enter="transition ease-out duration-100"
                                                 x-transition:enter-start="transform opacity-0 scale-95"
                                                 x-transition:enter-end="transform opacity-100 scale-100"
                                                 x-transition:leave="transition ease-in duration-75"
                                                 x-transition:leave-start="transform opacity-100 scale-100"
                                                 x-transition:leave-end="transform opacity-0 scale-95"
                                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-slate-200 z-10">
                                                <div class="py-1">
                                                    <a href="{{ route('posts.edit', $post) }}"
                                                       class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                        </svg>
                                                        Edit Post
                                                    </a>
                                                    <form method="POST" action="{{ route('posts.destroy', $post) }}" class="block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50"
                                                                onclick="return confirm('Are you sure you want to delete this post? This action cannot be undone.')">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                            Delete Post
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endcan
                                </div>

                                <!-- Post Title -->
                                <div class="mb-4">
                                    <h2 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-indigo-600 transition-colors">
                                        <a href="{{ route('posts.show', $post) }}" class="hover:underline">
                                            {{ $post->title }}
                                        </a>
                                    </h2>
                                </div>

                                <!-- Post Content Preview -->
                                <div class="text-slate-700 leading-relaxed mb-6">
                                    <div class="prose prose-slate max-w-none">
                                        {!! App\Utils\ContentFormatter::getPreviewText($post->content, 300) !!}
                                    </div>

                                    @if(strlen(strip_tags($post->content)) > 300)
                                        <div class="mt-3">
                                            <a href="{{ route('posts.show', $post) }}"
                                               class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium">
                                                Read full post
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                <!-- Post Footer -->
                                <div class="flex items-center justify-between pt-4 border-t border-slate-200">
                                    <div class="flex items-center space-x-4">
                                        <!-- Like Button -->
                                        <button onclick="toggleLike({{ $post->id }})"
                                                id="like-btn-{{ $post->id }}"
                                                class="flex items-center space-x-2 text-slate-500 hover:text-red-600 transition-colors {{ $post->isLikedBy(auth()->user()) ? 'text-red-600' : '' }}">
                                            <svg class="w-5 h-5" fill="{{ $post->isLikedBy(auth()->user()) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                            </svg>
                                            <span class="text-sm font-medium" id="like-count-{{ $post->id }}">{{ $post->likes_count ?? $post->likes->count() }}</span>
                                        </button>

                                        <!-- Comment Button -->
                                        <button onclick="toggleComments({{ $post->id }})"
                                                class="flex items-center space-x-2 text-slate-500 hover:text-blue-600 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                            </svg>
                                            <span class="text-sm font-medium" id="comment-count-{{ $post->id }}">{{ $post->comments_count ?? $post->comments->count() }}</span>
                                        </button>

                                        <!-- Share Button -->
                                        <button class="flex items-center space-x-2 text-slate-500 hover:text-indigo-600 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"/>
                                            </svg>
                                            <span class="text-sm font-medium">Share</span>
                                        </button>
                                    </div>

                                    <div class="flex items-center space-x-2">
                                        @if($post->is_ai_generated)
                                            <div class="flex items-center text-xs text-purple-600 bg-purple-50 px-2 py-1 rounded-full">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                                </svg>
                                                AI Enhanced
                                            </div>
                                        @endif
                                        <a href="{{ route('posts.show', $post) }}"
                                           class="text-sm text-slate-500 hover:text-indigo-600 font-medium">
                                            View Details
                                        </a>
                                    </div>
                                </div>

                                <!-- Comments Section -->
                                <div id="comments-section-{{ $post->id }}" class="hidden mt-4 pt-4 border-t border-slate-200">
                                    <!-- Comment Form -->
                                    <form onsubmit="submitComment(event, {{ $post->id }})" class="mb-4">
                                        <div class="flex space-x-3">
                                            <x-user-avatar :user="auth()->user()" size="sm" />
                                            <div class="flex-1">
                                                <textarea name="content"
                                                        id="comment-input-{{ $post->id }}"
                                                        placeholder="Write a comment..."
                                                        rows="2"
                                                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 resize-none"></textarea>
                                                <div class="flex justify-end mt-2">
                                                    <button type="submit"
                                                            class="btn-primary text-sm py-1 px-3">
                                                        Post Comment
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <!-- Comments List -->
                                    <div id="comments-list-{{ $post->id }}" class="space-y-3">
                                        @foreach($post->comments->take(3) as $comment)
                                            <div class="flex space-x-3" id="comment-{{ $comment->id }}">
                                                <x-user-avatar :user="$comment->user" size="sm" />
                                                <div class="flex-1">
                                                    <div class="bg-slate-50 rounded-lg px-3 py-2">
                                                        <div class="flex items-center justify-between mb-1">
                                                            <span class="font-medium text-sm text-slate-900">{{ $comment->user->name }}</span>
                                                            <div class="flex items-center space-x-2">
                                                                <span class="text-xs text-slate-500">{{ $comment->created_at->diffForHumans() }}</span>
                                                                @if($comment->user_id === auth()->id() || $post->user_id === auth()->id())
                                                                    <button onclick="deleteComment({{ $comment->id }})"
                                                                            class="text-xs text-red-600 hover:text-red-800">
                                                                        Delete
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <p class="text-sm text-slate-700">{{ $comment->content }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                        @if($post->comments->count() > 3)
                                            <div class="text-center">
                                                <a href="{{ route('posts.show', $post) }}"
                                                   class="text-sm text-indigo-600 hover:text-indigo-800">
                                                    View all {{ $post->comments->count() }} comments
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($posts->hasPages())
                    <div class="mt-8">
                        <div class="flex justify-center">
                            {{ $posts->links() }}
                        </div>
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="card">
                    <div class="card-body text-center py-16">
                        <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-3">No Posts Yet</h3>
                        <p class="text-slate-600 mb-8 max-w-md mx-auto">
                            Start sharing your thoughts with the world! Create your first post or connect with others to see their content in your feed.
                        </p>
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                            <a href="{{ route('posts.create') }}" class="btn-primary">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Create Your First Post
                            </a>
                            <a href="{{ route('ai-posts.create') }}" class="btn-ai">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                                Generate with AI
                            </a>
                            <a href="{{ route('invitations.create') }}" class="btn-secondary">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                Find Connections
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Toggle Like Function
        async function toggleLike(postId) {
            const likeBtn = document.getElementById(`like-btn-${postId}`);
            const likeCount = document.getElementById(`like-count-${postId}`);
            const heartIcon = likeBtn.querySelector('svg');

            try {
                showLoading('Processing...');

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
                    showToast(data.message, 'success');
                } else {
                    showToast(data.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Something went wrong. Please try again.', 'error');
            } finally {
                hideLoading();
            }
        }

        // Toggle Comments Section
        function toggleComments(postId) {
            const commentsSection = document.getElementById(`comments-section-${postId}`);
            const commentInput = document.getElementById(`comment-input-${postId}`);

            if (commentsSection.classList.contains('hidden')) {
                commentsSection.classList.remove('hidden');
                commentInput.focus();
            } else {
                commentsSection.classList.add('hidden');
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
                showToast('Please enter a comment', 'error');
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
                            <div class="w-8 h-8 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                ${data.comment.user_name.charAt(0).toUpperCase()}
                            </div>
                            <div class="flex-1">
                                <div class="bg-slate-50 rounded-lg px-3 py-2">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="font-medium text-sm text-slate-900">${data.comment.user_name}</span>
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xs text-slate-500">${data.comment.created_at}</span>
                                            ${data.comment.can_delete ? `<button onclick="deleteComment(${data.comment.id})" class="text-xs text-red-600 hover:text-red-800">Delete</button>` : ''}
                                        </div>
                                    </div>
                                    <p class="text-sm text-slate-700">${data.comment.content}</p>
                                </div>
                            </div>
                        </div>
                    `;

                    // Add comment to the top of the list
                    commentsList.insertAdjacentHTML('afterbegin', commentHtml);

                    // Update comment count
                    commentCount.textContent = data.comments_count;

                    // Clear input and show success message
                    commentInput.value = '';
                    showToast(data.message, 'success');
                } else {
                    showToast(data.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Something went wrong. Please try again.', 'error');
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

                    // Update comment counts for all posts (we don't know which post this comment belongs to)
                    document.querySelectorAll('[id^="comment-count-"]').forEach(countElement => {
                        // This is a simple approach - in a real app you might want to be more precise
                        const currentCount = parseInt(countElement.textContent);
                        if (currentCount > 0) {
                            countElement.textContent = data.comments_count;
                        }
                    });

                    showToast(data.message, 'success');
                } else {
                    showToast(data.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Something went wrong. Please try again.', 'error');
            }
        }
    </script>
</x-app-layout>
