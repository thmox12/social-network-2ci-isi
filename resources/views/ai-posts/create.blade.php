{{-- resources/views/ai-posts/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-gradient-to-r from-purple-100 to-indigo-100 rounded-xl">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-slate-900">AI Content Generator</h2>
                <p class="text-slate-600">Create engaging posts with artificial intelligence</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Form -->
                <div class="lg:col-span-2">
                    <div class="card">
                        <div class="card-body">
                            <!-- Feature Explanation -->
                            <div class="mb-8 p-6 bg-gradient-to-br from-purple-50 to-indigo-50 rounded-xl border border-purple-100">
                                <div class="flex items-start space-x-4">
                                    <div class="p-2 bg-purple-100 rounded-lg flex-shrink-0">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-purple-900 mb-2">How AI Generation Works</h3>
                                        <div class="text-sm text-purple-700 space-y-2">
                                            <p>• <strong>Describe your topic:</strong> Tell us what you want to write about</p>
                                            <p>• <strong>AI creates content:</strong> Our AI generates engaging, personalized content</p>
                                            <p>• <strong>Review & edit:</strong> Preview and customize before publishing</p>
                                            <p>• <strong>Share instantly:</strong> Post directly to your network</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form id="ai-post-form" method="POST" action="{{ route('ai-posts.generate') }}">
                                @csrf

                                <div class="space-y-6">
                                    <!-- Main Input -->
                                    <div>
                                        <label for="prompt" class="form-label">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-1l-4 4z"/>
                                                </svg>
                                                What would you like to write about?
                                            </span>
                                        </label>
                                        <div class="relative">
                                            <textarea name="prompt"
                                                      id="prompt"
                                                      rows="4"
                                                      placeholder="Tell me about your recent weekend adventure, share your thoughts on a book you read, describe your favorite recipe, talk about a new hobby you picked up..."
                                                      class="form-textarea"
                                                      required>{{ old('prompt') }}</textarea>
                                            <div class="absolute bottom-3 right-3 text-xs text-slate-400" id="char-count">
                                                0 / 500 characters
                                            </div>
                                        </div>
                                        @error('prompt')
                                            <p class="form-error">{{ $message }}</p>
                                        @enderror
                                        <p class="form-help">
                                            💡 <strong>Pro tip:</strong> Be specific and descriptive for better AI-generated content. Include emotions, details, and context.
                                        </p>
                                    </div>

                                    <!-- Tone Selection -->
                                    <div>
                                        <label class="form-label">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.01M15 10h1.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                Writing Tone (Optional)
                                            </span>
                                        </label>
                                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                            <label class="relative cursor-pointer">
                                                <input type="radio" name="tone" value="casual" class="sr-only peer" checked>
                                                <div class="p-3 border-2 border-slate-200 rounded-lg text-center transition-all peer-checked:border-indigo-500 peer-checked:bg-indigo-50 hover:border-slate-300">
                                                    <div class="text-sm font-medium text-slate-900">😊 Casual</div>
                                                    <div class="text-xs text-slate-500">Friendly & relaxed</div>
                                                </div>
                                            </label>
                                            <label class="relative cursor-pointer">
                                                <input type="radio" name="tone" value="professional" class="sr-only peer">
                                                <div class="p-3 border-2 border-slate-200 rounded-lg text-center transition-all peer-checked:border-indigo-500 peer-checked:bg-indigo-50 hover:border-slate-300">
                                                    <div class="text-sm font-medium text-slate-900">👔 Professional</div>
                                                    <div class="text-xs text-slate-500">Formal & polished</div>
                                                </div>
                                            </label>
                                            <label class="relative cursor-pointer">
                                                <input type="radio" name="tone" value="enthusiastic" class="sr-only peer">
                                                <div class="p-3 border-2 border-slate-200 rounded-lg text-center transition-all peer-checked:border-indigo-500 peer-checked:bg-indigo-50 hover:border-slate-300">
                                                    <div class="text-sm font-medium text-slate-900">🎉 Enthusiastic</div>
                                                    <div class="text-xs text-slate-500">Excited & energetic</div>
                                                </div>
                                            </label>
                                            <label class="relative cursor-pointer">
                                                <input type="radio" name="tone" value="thoughtful" class="sr-only peer">
                                                <div class="p-3 border-2 border-slate-200 rounded-lg text-center transition-all peer-checked:border-indigo-500 peer-checked:bg-indigo-50 hover:border-slate-300">
                                                    <div class="text-sm font-medium text-slate-900">🤔 Thoughtful</div>
                                                    <div class="text-xs text-slate-500">Reflective & deep</div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Length Selection -->
                                    <div>
                                        <label class="form-label">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                Content Length
                                            </span>
                                        </label>
                                        <div class="flex space-x-4">
                                            <label class="flex items-center cursor-pointer">
                                                <input type="radio" name="length" value="short" class="form-radio" checked>
                                                <span class="ml-2 text-sm text-slate-700">Short (1-2 paragraphs)</span>
                                            </label>
                                            <label class="flex items-center cursor-pointer">
                                                <input type="radio" name="length" value="medium" class="form-radio">
                                                <span class="ml-2 text-sm text-slate-700">Medium (3-4 paragraphs)</span>
                                            </label>
                                            <label class="flex items-center cursor-pointer">
                                                <input type="radio" name="length" value="long" class="form-radio">
                                                <span class="ml-2 text-sm text-slate-700">Long (5+ paragraphs)</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-8 border-t border-slate-200">
                                    <a href="{{ route('posts.index') }}"
                                       class="btn-secondary">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                        </svg>
                                        Back to Posts
                                    </a>
                                    <button type="submit"
                                            class="btn-ai"
                                            id="generate-btn">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                        Generate Content
                                        <div class="ml-2 w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin hidden" id="generate-spinner"></div>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Tips Card -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-lg font-semibold text-slate-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                                Writing Tips
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="space-y-4 text-sm">
                                <div class="flex items-start space-x-3">
                                    <div class="w-2 h-2 bg-emerald-500 rounded-full mt-2 flex-shrink-0"></div>
                                    <div>
                                        <p class="font-medium text-slate-900">Be specific</p>
                                        <p class="text-slate-600">Include details, names, places, and emotions</p>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
                                    <div>
                                        <p class="font-medium text-slate-900">Add context</p>
                                        <p class="text-slate-600">Explain why this topic matters to you</p>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <div class="w-2 h-2 bg-purple-500 rounded-full mt-2 flex-shrink-0"></div>
                                    <div>
                                        <p class="font-medium text-slate-900">Include questions</p>
                                        <p class="text-slate-600">Engage your audience with thought-provoking questions</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Examples Card -->
                        {{-- <div class="card">
                            <div class="card-header">
                                <h3 class="text-lg font-semibold text-slate-900 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 002 2v14a2 2 0 002 2z"/>
                                    </svg>
                                    Example Prompts
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="space-y-3">
                                    <button type="button"
                                            class="w-full text-left p-3 bg-slate-50 hover:bg-slate-100 rounded-lg border border-slate-200 transition-colors text-sm example-prompt"
                                            data-prompt="I just finished reading 'The Seven Husbands of Evelyn Hugo' and I'm completely blown away. The way Taylor Jenkins Reid crafted this story about old Hollywood glamour and the secrets we keep was absolutely masterful. What's a book that completely surprised you and left you thinking about it for days?">
                                        <div class="font-medium text-slate-900 mb-1">📚 Book Recommendation</div>
                                        <div class="text-slate-600 text-xs">Share a book that moved you</div>
                                    </button>
                                    <button type="button"
                                            class="w-full text-left p-3 bg-slate-50 hover:bg-slate-100 rounded-lg border border-slate-200 transition-colors text-sm example-prompt"
                                            data-prompt="Spent the weekend hiking through Glacier National Park and I'm still processing the incredible views. There's something about being surrounded by those towering peaks and crystal-clear lakes that puts everything in perspective. The trail to Hidden Lake was challenging but so worth it. Nature has this amazing way of reminding us what really matters.">
                                        <div class="font-medium text-slate-900 mb-1">🏔️ Travel Experience</div>
                                        <div class="text-slate-600 text-xs">Share an adventure or trip</div>
                                    </button>
                                    <button type="button"
                                            class="w-full text-left p-3 bg-slate-50 hover:bg-slate-100 rounded-lg border border-slate-200 transition-colors text-sm example-prompt"
                                            data-prompt="I've been experimenting with sourdough baking for the past month, and today I finally achieved that perfect golden crust and airy crumb I've been chasing. The process taught me so much about patience and the science behind fermentation. There's something deeply satisfying about creating something from just flour, water, and time.">
                                        <div class="font-medium text-slate-900 mb-1">🍞 New Hobby</div>
                                        <div class="text-slate-600 text-xs">Share a skill you're learning</div>
                                    </button>
                                </div>
                            </div>
                        </div> --}}
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Prevent accidental navigation to generate route via GET
            if (window.location.pathname.includes('/ai-posts/generate') && !document.referrer.includes('/ai-posts/create')) {
                console.warn('Detected potential GET request to generate route, redirecting to create');
                window.location.href = "{{ route('ai-posts.create') }}";
                return;
            }

            // Character counter
            const promptTextarea = document.getElementById('prompt');
            const charCount = document.getElementById('char-count');

            function updateCharCount() {
                const length = promptTextarea.value.length;
                charCount.textContent = `${length} / 500 characters`;
                charCount.classList.toggle('text-red-500', length > 500);
            }

            promptTextarea.addEventListener('input', updateCharCount);

            // Initialize char count
            updateCharCount();

            // Auto-resize textarea function
            function autoResizeTextarea(textarea) {
                textarea.style.height = 'auto';
                textarea.style.height = (textarea.scrollHeight) + 'px';
            }

            // Auto-resize on input
            promptTextarea.addEventListener('input', function() {
                autoResizeTextarea(this);
            });

            // Example prompt buttons
            document.querySelectorAll('.example-prompt').forEach(button => {
                button.addEventListener('click', function(e) {
                    // Prevent any default behavior
                    e.preventDefault();
                    e.stopPropagation();

                    console.log('=== EXAMPLE PROMPT CLICKED ===');
                    console.log('Button type:', this.type);
                    console.log('Prompt:', this.dataset.prompt);

                    const prompt = this.dataset.prompt;
                    promptTextarea.value = prompt;
                    updateCharCount();
                    autoResizeTextarea(promptTextarea);

                    // Highlight the textarea briefly
                    promptTextarea.focus();
                    promptTextarea.classList.add('ring-2', 'ring-indigo-500', 'ring-opacity-50');
                    setTimeout(() => {
                        promptTextarea.classList.remove('ring-2', 'ring-indigo-500', 'ring-opacity-50');
                    }, 1000);

                    console.log('Example prompt applied successfully');
                });
            });

            // Form submission with debugging
            const form = document.getElementById('ai-post-form');
            const generateBtn = document.getElementById('generate-btn');
            const generateSpinner = document.getElementById('generate-spinner');

            // Debug form properties
            console.log('=== FORM DEBUG INFO ===');
            console.log('Form element:', form);
            console.log('Form method:', form.method);
            console.log('Form action:', form.action);
            console.log('Expected action:', "{{ route('ai-posts.generate') }}");

            form.addEventListener('submit', function(e) {
                console.log('=== FORM SUBMISSION ===');
                console.log('Form method:', form.method);
                console.log('Form action:', form.action);

                // Ensure form is submitting to the correct route
                const expectedAction = "{{ route('ai-posts.generate') }}";
                if (form.action !== expectedAction) {
                    console.warn('Form action mismatch! Correcting...');
                    console.warn('Current:', form.action);
                    console.warn('Expected:', expectedAction);
                    form.action = expectedAction;
                }

                // Ensure method is POST
                if (form.method.toLowerCase() !== 'post') {
                    console.warn('Form method is not POST! Correcting...');
                    form.method = 'POST';
                }

                // Log form data
                const formData = new FormData(form);
                console.log('Form data:');
                for (let [key, value] of formData.entries()) {
                    console.log(`${key}: ${value}`);
                }

                // Validate prompt is not empty
                const prompt = formData.get('prompt');
                if (!prompt || prompt.trim() === '') {
                    e.preventDefault();
                    alert('Please enter a prompt to generate content.');
                    // Restore button state
                    generateBtn.disabled = false;
                    generateBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    generateSpinner.classList.add('hidden');
                    return;
                }

                // Show loading state
                generateBtn.disabled = true;
                generateBtn.classList.add('opacity-50', 'cursor-not-allowed');
                generateSpinner.classList.remove('hidden');

                // Update button text
                const buttonText = generateBtn.querySelector('svg').nextSibling;
                if (buttonText) {
                    buttonText.textContent = ' Generating...';
                }
            });
        });
    </script>
</x-app-layout>
