{{-- resources/views/ai-posts/preview.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Preview AI Generated Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <!-- Display any errors -->
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <div class="flex items-center space-x-2 mb-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900">Content Generated Successfully!</h3>
                        </div>
                        <div class="bg-green-50 border border-green-200 rounded-md p-4">
                            <p class="text-sm text-green-700">
                                <strong>Prompt:</strong> "{{ $prompt }}"
                            </p>
                        </div>
                    </div>

                    <!-- Preview Section -->
                    <div class="mb-6 bg-gray-50 border border-gray-200 rounded-md p-4">
                        <h4 class="text-md font-medium text-gray-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Preview - How it will look:
                        </h4>
                        <div class="bg-white p-4 rounded border shadow-sm" id="post-preview">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h5 class="text-lg font-semibold text-gray-900 mb-1" id="preview-title">{{ $title }}</h5>
                                    <p class="text-sm text-gray-600">
                                        by {{ auth()->user()->name }}
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 ml-2">
                                            AI Generated
                                        </span>
                                    </p>
                                </div>
                                <span class="text-sm text-gray-500">Just now</span>
                            </div>
                            <div class="text-gray-700 text-sm leading-relaxed" id="preview-content">
                                @if(class_exists('App\Utils\ContentFormatter'))
                                    {!! App\Utils\ContentFormatter::formatContent($content) !!}
                                @else
                                    {!! nl2br(e($content)) !!}
                                @endif
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">
                            This is exactly how your post will appear to connected users.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('ai-posts.store') }}" id="publish-form">
                        @csrf
                        <input type="hidden" name="_method" value="POST">

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Title <span class="text-gray-500">(you can edit this)</span>
                            </label>
                            <input type="text" name="title" id="title"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                                   value="{{ old('title', $title) }}" required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                                Generated Content <span class="text-gray-500">(you can edit this)</span>
                            </label>
                            <textarea name="content" id="content" rows="10"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                                      required>{{ old('content', $content) }}</textarea>
                            @error('content')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">
                                Review and edit the generated content as needed before publishing. The preview above updates as you edit.
                            </p>
                        </div>

                        <div class="mb-6 bg-purple-50 border border-purple-200 rounded-md p-4">
                            <div class="flex items-center">
                                <input type="checkbox" id="ai_notice" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded" checked disabled>
                                <label for="ai_notice" class="ml-2 block text-sm text-purple-700">
                                    This post will be marked as AI-generated
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-between">
                            <a href="{{ route('ai-posts.create') }}"
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Generate New Content
                            </a>
                            <div class="space-x-2">
                                <button type="submit"
                                        class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded"
                                        id="publish-btn">
                                    Publish Post
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('publish-form');
            const publishBtn = document.getElementById('publish-btn');
            const titleInput = document.getElementById('title');
            const contentTextarea = document.getElementById('content');

            // Prevent browser back button issues and accidental navigation
            if (window.history && window.history.pushState) {
                window.addEventListener('popstate', function(e) {
                    e.preventDefault();
                    window.location.href = "{{ route('ai-posts.create') }}";
                });
            }

            // Prevent accidental GET requests to generate route
            window.addEventListener('beforeunload', function(e) {
                // Clear any potential navigation to generate route
                if (window.location.href.includes('/ai-posts/generate')) {
                    window.location.href = "{{ route('ai-posts.create') }}";
                }
            });

            // Debug form properties
            console.log('=== PREVIEW FORM DEBUG ===');
            console.log('Form method:', form.method);
            console.log('Form action:', form.action);
            console.log('Expected action:', "{{ route('ai-posts.store') }}");

            // Ensure form action is always correct
            const correctAction = "{{ route('ai-posts.store') }}";
            if (form.action !== correctAction) {
                console.warn('Correcting form action from', form.action, 'to', correctAction);
                form.action = correctAction;
            }

            // Form submission handler
            form.addEventListener('submit', function(e) {
                console.log('=== PUBLISH FORM SUBMISSION ===');
                console.log('Form method:', form.method);
                console.log('Form action:', form.action);

                // Ensure the form is submitting to the correct route
                const expectedAction = "{{ route('ai-posts.store') }}";
                if (form.action !== expectedAction) {
                    console.error('Form action mismatch!');
                    console.error('Current action:', form.action);
                    console.error('Expected action:', expectedAction);
                    form.action = expectedAction;
                    console.log('Corrected form action to:', form.action);
                }

                // Ensure method is POST
                if (form.method.toLowerCase() !== 'post') {
                    console.error('Form method is not POST:', form.method);
                    form.method = 'POST';
                    console.log('Corrected form method to POST');
                }

                // Log form data
                const formData = new FormData(form);
                console.log('Form data:');
                for (let [key, value] of formData.entries()) {
                    console.log(`${key}: ${value}`);
                }

                // Validate required fields
                const title = formData.get('title');
                const content = formData.get('content');
                const csrfToken = formData.get('_token');

                if (!title || !content) {
                    e.preventDefault();
                    console.error('Missing required fields:', { title: !!title, content: !!content });
                    alert('Please fill in both title and content.');
                    publishBtn.disabled = false;
                    publishBtn.textContent = 'Publish Post';
                    publishBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    return;
                }

                if (!csrfToken) {
                    e.preventDefault();
                    console.error('Missing CSRF token');
                    alert('Security token missing. Please refresh the page and try again.');
                    publishBtn.disabled = false;
                    publishBtn.textContent = 'Publish Post';
                    publishBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    return;
                }

                // Show loading state
                publishBtn.disabled = true;
                publishBtn.textContent = 'Publishing...';
                publishBtn.classList.add('opacity-50', 'cursor-not-allowed');
            });

            // Live preview updates
            function updatePreviewTitle(title) {
                const previewTitle = document.getElementById('preview-title');
                if (previewTitle) {
                    previewTitle.textContent = title || 'Untitled Post';
                }
            }

            function updatePreviewContent(content) {
                const previewContent = document.getElementById('preview-content');
                if (previewContent) {
                    // Basic client-side formatting
                    let formatted = content
                        .replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>')
                        .replace(/\*([^*]+)\*/g, '<em>$1</em>')
                        .replace(/#(\w+)/g, '<span class="inline-block bg-blue-100 text-blue-800 text-sm px-2 py-1 rounded mr-1">#$1</span>')
                        .replace(/\n/g, '<br>');

                    previewContent.innerHTML = formatted || 'No content';
                }
            }

            // Listen for changes to title and content
            titleInput.addEventListener('input', function() {
                updatePreviewTitle(this.value);
            });

            contentTextarea.addEventListener('input', function() {
                updatePreviewContent(this.value);
            });

            // Auto-resize textarea
            function autoResizeTextarea(textarea) {
                textarea.style.height = 'auto';
                textarea.style.height = (textarea.scrollHeight) + 'px';
            }

            contentTextarea.addEventListener('input', function() {
                autoResizeTextarea(this);
            });

            // Initialize textarea height
            autoResizeTextarea(contentTextarea);

            // Ensure "Generate New Content" link works correctly
            const generateNewLink = document.querySelector('a[href*="ai-posts/create"]');
            if (generateNewLink) {
                generateNewLink.addEventListener('click', function(e) {
                    console.log('Navigating to create page:', this.href);
                    // Allow normal navigation
                });
            }

            // Prevent any accidental form submissions to wrong routes
            document.addEventListener('click', function(e) {
                const target = e.target;
                if (target.tagName === 'A' && target.href && target.href.includes('/ai-posts/generate')) {
                    console.warn('Preventing navigation to generate route via link');
                    e.preventDefault();
                    window.location.href = "{{ route('ai-posts.create') }}";
                }
            });
        });
    </script>
</x-app-layout>
