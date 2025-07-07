{{-- Enhanced Toast notification component --}}
@php
    $toastId = $id ?? 'toast-' . uniqid();
    $iconColors = [
        'success' => 'text-emerald-600',
        'error' => 'text-red-600',
        'warning' => 'text-amber-600',
        'info' => 'text-blue-600',
        'like' => 'text-pink-600',
        'comment' => 'text-blue-600',
        'notification' => 'text-indigo-600'
    ];
    $bgGradients = [
        'success' => 'bg-gradient-to-r from-emerald-50 to-green-50 border-emerald-200',
        'error' => 'bg-gradient-to-r from-red-50 to-rose-50 border-red-200',
        'warning' => 'bg-gradient-to-r from-amber-50 to-yellow-50 border-amber-200',
        'info' => 'bg-gradient-to-r from-blue-50 to-indigo-50 border-blue-200',
        'like' => 'bg-gradient-to-r from-pink-50 to-rose-50 border-pink-200',
        'comment' => 'bg-gradient-to-r from-blue-50 to-cyan-50 border-blue-200',
        'notification' => 'bg-gradient-to-r from-indigo-50 to-purple-50 border-indigo-200'
    ];

    $bgClass = $bgGradients[$type] ?? 'bg-white border-slate-200';
    $iconColor = $iconColors[$type] ?? 'text-slate-600';
@endphp

<div id="{{ $toastId }}"
     class="toast-notification fixed top-4 right-4 z-50 max-w-sm w-full transform translate-x-full opacity-0 transition-all duration-300 ease-out"
     style="margin-top: calc(var(--toast-index, 0) * 4.5rem);">
    <div class="relative {{ $bgClass }} shadow-lg rounded-xl border backdrop-blur-sm overflow-hidden">
        <!-- Progress bar for auto-dismiss -->
        @if($autoDismiss ?? true)
            <div class="absolute top-0 left-0 h-1 bg-gradient-to-r from-blue-500 to-purple-500 toast-progress"
                 style="width: 100%; animation: toast-progress {{ $duration ?? 5 }}s linear;"></div>
        @endif

        <div class="p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    @if($type === 'success')
                        <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 {{ $iconColor }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    @elseif($type === 'error')
                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 {{ $iconColor }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    @elseif($type === 'warning')
                        <div class="w-8 h-8 bg-amber-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 {{ $iconColor }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    @elseif($type === 'like')
                        <div class="w-8 h-8 bg-pink-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 {{ $iconColor }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/>
                            </svg>
                        </div>
                    @elseif($type === 'comment')
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 {{ $iconColor }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    @elseif($type === 'notification')
                        <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 {{ $iconColor }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                            </svg>
                        </div>
                    @else
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 {{ $iconColor }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    @endif
                </div>

                <div class="ml-3 w-0 flex-1">
                    @if(isset($title))
                        <p class="text-sm font-semibold text-slate-900">{{ $title }}</p>
                    @endif
                    <p class="text-sm {{ isset($title) ? 'text-slate-600 mt-1' : 'text-slate-900 font-medium' }}">
                        {{ $message }}
                    </p>
                    @if(isset($action))
                        <div class="mt-2">
                            <a href="{{ $action['url'] }}"
                               class="text-xs font-medium {{ $iconColor }} hover:opacity-80 transition-opacity">
                                {{ $action['text'] }}
                            </a>
                        </div>
                    @endif
                </div>

                <div class="ml-4 flex-shrink-0 flex">
                    <button onclick="hideToast('{{ $toastId }}')"
                            class="inline-flex text-slate-400 hover:text-slate-600 focus:outline-none focus:text-slate-600 transition-colors rounded-full p-1 hover:bg-slate-100">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes toast-progress {
        from { width: 100%; }
        to { width: 0%; }
    }

    .toast-notification.show {
        transform: translateX(0);
        opacity: 1;
    }

    .toast-notification.hide {
        transform: translateX(100%);
        opacity: 0;
    }
</style>
