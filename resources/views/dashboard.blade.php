{{-- resources/views/dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">
                    Welcome back, {{ auth()->user()->name }}! 👋
                </h2>
                <p class="text-slate-600 mt-1">Here's what's happening in your network</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="text-right">
                    <p class="text-sm font-medium text-slate-900">{{ auth()->user()->getAllConnections()->count() }}</p>
                    <p class="text-xs text-slate-500">Connections</p>
                </div>
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center">
                            <div class="p-3 bg-blue-100 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-2xl font-bold text-slate-900">{{ auth()->user()->posts()->count() }}</p>
                                <p class="text-sm text-slate-500">Your Posts</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center">
                            <div class="p-3 bg-emerald-100 rounded-lg">
                                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-2xl font-bold text-slate-900">{{ auth()->user()->getAllConnections()->count() }}</p>
                                <p class="text-sm text-slate-500">Connections</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center">
                            <div class="p-3 bg-amber-100 rounded-lg">
                                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-2xl font-bold text-slate-900">{{ auth()->user()->receivedInvitations()->where('status', 'pending')->count() }}</p>
                                <p class="text-sm text-slate-500">Pending Invites</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center">
                            <div class="p-3 bg-purple-100 rounded-lg">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-2xl font-bold text-slate-900">{{ auth()->user()->posts()->where('is_ai_generated', true)->count() }}</p>
                                <p class="text-sm text-slate-500">AI Posts</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Posts Section -->
                <div class="card">
                    <div class="card-header">
                        <div class="flex items-center">
                            <div class="p-2 bg-blue-100 rounded-lg">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                            </div>
                            <h3 class="ml-3 text-lg font-semibold text-slate-900">Content Creation</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-slate-600 mb-6">Share your thoughts and connect with your network</p>
                        <div class="space-y-3">
                            <a href="{{ route('posts.index') }}" 
                               class="btn-secondary w-full justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                View All Posts
                            </a>
                            <a href="{{ route('posts.create') }}" 
                               class="btn-primary w-full justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Create New Post
                            </a>
                            <a href="{{ route('ai-posts.create') }}" 
                               class="btn-ai w-full justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                                Generate with AI
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Invitations Section -->
                <div class="card">
                    <div class="card-header">
                        <div class="flex items-center">
                            <div class="p-2 bg-emerald-100 rounded-lg">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <h3 class="ml-3 text-lg font-semibold text-slate-900">Network Building</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-slate-600 mb-6">Grow your network by connecting with others</p>
                        <div class="space-y-3">
                            <a href="{{ route('invitations.index') }}" 
                               class="btn-secondary w-full justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                                </svg>
                                Manage Invitations
                                @if(auth()->user()->receivedInvitations()->where('status', 'pending')->count() > 0)
                                    <span class="ml-2 badge badge-pending">{{ auth()->user()->receivedInvitations()->where('status', 'pending')->count() }}</span>
                                @endif
                            </a>
                            <a href="{{ route('invitations.create') }}" 
                               class="btn-success w-full justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Send Invitation
                            </a>
                        </div>
                        
                        @if(auth()->user()->getAllConnections()->count() > 0)
                            <div class="mt-6 pt-6 border-t border-slate-200">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="text-sm font-medium text-slate-900">Recent Connections</h4>
                                    <span class="text-xs text-slate-500">{{ auth()->user()->getAllConnections()->count() }} total</span>
                                </div>
                                <div class="flex -space-x-2">
                                    @foreach(auth()->user()->getAllConnections()->take(5) as $connection)
                                        <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white text-xs font-medium border-2 border-white" 
                                             title="{{ $connection->name }}">
                                            {{ strtoupper(substr($connection->name, 0, 1)) }}
                                        </div>
                                    @endforeach
                                    @if(auth()->user()->getAllConnections()->count() > 5)
                                        <div class="w-8 h-8 bg-slate-200 rounded-full flex items-center justify-center text-slate-600 text-xs font-medium border-2 border-white">
                                            +{{ auth()->user()->getAllConnections()->count() - 5 }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Activity Overview -->
                <div class="card">
                    <div class="card-header">
                        <div class="flex items-center">
                            <div class="p-2 bg-indigo-100 rounded-lg">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                            </div>
                            <h3 class="ml-3 text-lg font-semibold text-slate-900">Your Activity</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-slate-600 mb-6">Track your engagement and growth</p>
                        
                        <div class="space-y-4">
                            @php
                                $totalPosts = auth()->user()->posts()->count();
                                $aiPosts = auth()->user()->posts()->where('is_ai_generated', true)->count();
                                $connections = auth()->user()->getAllConnections()->count();
                                $recentActivity = auth()->user()->posts()->latest()->take(3)->get();
                            @endphp

                            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                    <span class="text-sm text-slate-700">Posts Created</span>
                                </div>
                                <span class="text-sm font-semibold text-slate-900">{{ $totalPosts }}</span>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 bg-purple-500 rounded-full mr-3"></div>
                                    <span class="text-sm text-slate-700">AI Assisted</span>
                                </div>
                                <span class="text-sm font-semibold text-slate-900">{{ $aiPosts }}</span>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 bg-emerald-500 rounded-full mr-3"></div>
                                    <span class="text-sm text-slate-700">Network Size</span>
                                </div>
                                <span class="text-sm font-semibold text-slate-900">{{ $connections }}</span>
                            </div>

                            @if($recentActivity->count() > 0)
                                <div class="pt-4 border-t border-slate-200">
                                    <h4 class="text-sm font-medium text-slate-900 mb-3">Recent Activity</h4>
                                    <div class="space-y-2">
                                        @foreach($recentActivity as $post)
                                            <div class="text-xs text-slate-600">
                                                <span class="font-medium">{{ $post->created_at->diffForHumans() }}</span>
                                                - Posted "{{ Str::limit($post->title, 25) }}"
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>