{{-- resources/views/invitations/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-gradient-to-r from-emerald-100 to-blue-100 rounded-xl">
                <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Send Connection Invitation</h2>
                <p class="text-slate-600">Grow your network by connecting with other users</p>
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
                            <form id="invitation-form" method="POST" action="{{ route('invitations.store') }}">
                                @csrf

                                <div class="space-y-6">
                                    <!-- User Selection -->
                                    <div>
                                        <label for="receiver_id" class="form-label">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                                Select User to Connect With
                                            </span>
                                        </label>
                                        <div class="relative">
                                            <select name="receiver_id" id="receiver_id"
                                                    class="form-input pr-10"
                                                    required>
                                                <option value="">Choose a user to connect with...</option>
                                                @foreach($users as $user)
                                                    @if(!auth()->user()->isConnectedTo($user) && !auth()->user()->hasInvitationFrom($user) && !auth()->user()->hasSentInvitationTo($user))
                                                        <option value="{{ $user->id }}" {{ old('receiver_id') == $user->id ? 'selected' : '' }}>
                                                            {{ $user->name }} • {{ $user->email }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                                                </svg>
                                            </div>
                                        </div>
                                        @error('receiver_id')
                                            <p class="form-error">{{ $message }}</p>
                                        @enderror
                                        <p class="form-help">
                                            💡 Only users you haven't connected with yet are shown in this list.
                                        </p>
                                    </div>

                                    <!-- Personal Message (Optional) -->
                                    <div>
                                        <label for="message" class="form-label">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-1l-4 4z"/>
                                                </svg>
                                                Personal Message (Optional)
                                            </span>
                                        </label>
                                        <textarea name="message"
                                                  id="message"
                                                  rows="4"
                                                  data-auto-resize
                                                  placeholder="Hi! I'd love to connect with you on our social network. Looking forward to sharing ideas and staying in touch!"
                                                  class="form-textarea">{{ old('message') }}</textarea>
                                        @error('message')
                                            <p class="form-error">{{ $message }}</p>
                                        @enderror
                                        <p class="form-help">
                                            Add a personal touch to your invitation. This helps the recipient understand why you'd like to connect.
                                        </p>
                                    </div>

                                    <!-- Connection Preferences -->
                                    <div>
                                        <label class="form-label">Connection Preferences</label>
                                        <div class="space-y-3">
                                            <label class="flex items-center">
                                                <input type="checkbox" name="preferences[]" value="posts"
                                                       class="rounded border-slate-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                       checked>
                                                <span class="ml-3 text-sm text-slate-700">Share posts with each other</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="checkbox" name="preferences[]" value="notifications"
                                                       class="rounded border-slate-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                       checked>
                                                <span class="ml-3 text-sm text-slate-700">Get notified of their new posts</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-8 border-t border-slate-200">
                                    <a href="{{ route('invitations.index') }}"
                                       class="btn-secondary">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                        </svg>
                                        Back to Invitations
                                    </a>
                                    <button type="submit"
                                            class="btn-success"
                                            onclick="showLoading('Sending invitation...')">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                        </svg>
                                        Send Invitation
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- How it Works -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-lg font-semibold text-slate-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                How Invitations Work
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="space-y-4 text-sm">
                                <div class="flex items-start space-x-3">
                                    <div class="w-6 h-6 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">1</div>
                                    <div>
                                        <p class="font-medium text-slate-900">Send Invitation</p>
                                        <p class="text-slate-600">Choose a user and optionally add a personal message</p>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <div class="w-6 h-6 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">2</div>
                                    <div>
                                        <p class="font-medium text-slate-900">They Receive It</p>
                                        <p class="text-slate-600">The user gets notified and can accept or decline</p>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <div class="w-6 h-6 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">3</div>
                                    <div>
                                        <p class="font-medium text-slate-900">Connection Made</p>
                                        <p class="text-slate-600">Once accepted, you can see each other's posts</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Network Stats -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-lg font-semibold text-slate-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                                Your Network
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 bg-emerald-500 rounded-full mr-3"></div>
                                        <span class="text-sm text-slate-700">Active Connections</span>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-900">{{ auth()->user()->getAllConnections()->count() }}</span>
                                </div>

                                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 bg-amber-500 rounded-full mr-3"></div>
                                        <span class="text-sm text-slate-700">Pending Sent</span>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-900">{{ auth()->user()->sentInvitations()->where('status', 'pending')->count() }}</span>
                                </div>

                                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                        <span class="text-sm text-slate-700">Pending Received</span>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-900">{{ auth()->user()->receivedInvitations()->where('status', 'pending')->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tips -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-lg font-semibold text-slate-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                                Connection Tips
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="space-y-3 text-sm">
                                <div class="flex items-start space-x-2">
                                    <span class="text-emerald-500 mt-1">✓</span>
                                    <span class="text-slate-600">Include a personal message to increase acceptance rates</span>
                                </div>
                                <div class="flex items-start space-x-2">
                                    <span class="text-emerald-500 mt-1">✓</span>
                                    <span class="text-slate-600">Connect with people who share similar interests</span>
                                </div>
                                <div class="flex items-start space-x-2">
                                    <span class="text-emerald-500 mt-1">✓</span>
                                    <span class="text-slate-600">Be respectful and genuine in your approach</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form enhancement
            enhanceForm('invitation-form', {
                loadingMessage: 'Sending invitation...',
                showLoading: true
            });

            // User selection enhancement
            const userSelect = document.getElementById('receiver_id');
            userSelect.addEventListener('change', function() {
                if (this.value) {
                    // Add some visual feedback
                    this.classList.add('border-indigo-500', 'ring-1', 'ring-indigo-500');
                    setTimeout(() => {
                        this.classList.remove('border-indigo-500', 'ring-1', 'ring-indigo-500');
                    }, 2000);
                }
            });
        });
    </script>
</x-app-layout>
