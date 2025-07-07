{{-- resources/views/ai-posts/preview.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Preview AI Generated Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
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
                        <div class="bg-white p-4 rounded border shadow-sm">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h5 class="text-lg font-semibold text-gray-900 mb-1">{{ $title }}</h5>
                                    <p class="text-sm text-gray-600">
                                        by {{ auth()->user()->name }}
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 ml-2">
                                            AI Generated
                                        </span>
                                    </p>
                                </div>
                                <span class="text-sm text-gray-500">Just now</span>
                            </div>
                            <div class="text-gray-700 text-sm leading-relaxed">
                                {!! App\Utils\ContentFormatter::formatContent($content) !!}
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">
                            This is exactly how your post will appear to connected users.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('ai-posts.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Title <span class="text-gray-500">(you can edit this)</span>
                            </label>
                            <input type="text" name="title" id="title" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                                   value="{{ old('title', $title) }}" required
                                   onchange="updatePreviewTitle(this.value)">
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
                                      required
                                      onchange="updatePreviewContent(this.value)">{{ old('content', $content) }}</textarea>
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
                                        class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
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
        function updatePreviewTitle(title) {
            const previewTitle = document.querySelector('.bg-white.p-4.rounded.border h5');
            if (previewTitle) {
                previewTitle.textContent = title;
            }
        }

        function updatePreviewContent(content) {
            const previewContent = document.querySelector('.bg-white.p-4.rounded.border .text-gray-700');
            if (previewContent) {
                // Simple client-side formatting (basic)
                let formatted = content
                    .replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>')
                    .replace(/\*([^*]+)\*/g, '<em>$1</em>')
                    .replace(/#(\w+)/g, '<span class="inline-block bg-blue-100 text-blue-800 text-sm px-2 py-1 rounded mr-1">#$1</span>');
                
                previewContent.innerHTML = formatted.replace(/\n/g, '<br>');
            }
        }
    </script>
</x-app-layout>