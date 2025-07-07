{{-- Notification dropdown component --}}
<div x-data="{
    open: false,
    notifications: [],
    unreadCount: 0,
    loading: false,

    async fetchNotifications() {
        this.loading = true;
        try {
            const response = await fetch('/notifications/recent');
            const data = await response.json();
            this.notifications = data.notifications;
        } catch (error) {
            console.error('Error fetching notifications:', error);
        }
        this.loading = false;
    },

    async fetchUnreadCount() {
        try {
            const response = await fetch('/notifications/unread-count');
            const data = await response.json();
            this.unreadCount = data.count;
        } catch (error) {
            console.error('Error fetching unread count:', error);
        }
    },

    async markAsRead(notificationId) {
        try {
            await fetch(`/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                }
            });
            // Update local state
            const notification = this.notifications.find(n => n.id === notificationId);
            if (notification) {
                notification.read = true;
                if (this.unreadCount > 0) this.unreadCount--;
            }
        } catch (error) {
            console.error('Error marking notification as read:', error);
        }
    },

    async markAllAsRead() {
        try {
            await fetch('/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                }
            });
            // Update local state
            this.notifications.forEach(n => n.read = true);
            this.unreadCount = 0;
        } catch (error) {
            console.error('Error marking all notifications as read:', error);
        }
    }

}"
x-init="
    fetchUnreadCount();
    // Poll for new notifications every 30 seconds
    setInterval(() => fetchUnreadCount(), 30000);
"
class="relative">

    <button @click="open = !open; if(open && notifications.length === 0) fetchNotifications()"
            class="relative p-2 text-slate-600 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 rounded-lg transition-colors">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>

        <!-- Notification badge -->
        <span x-show="unreadCount > 0"
              x-text="unreadCount > 99 ? '99+' : unreadCount"
              class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full min-w-[1.25rem] h-5 flex items-center justify-center px-1">
        </span>
    </button>

    <!-- Dropdown -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         @click.away="open = false"
         class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-slate-200 z-50 max-h-96 overflow-hidden">

        <!-- Header -->
        <div class="p-4 border-b border-slate-200 bg-slate-50">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-slate-900">Notifications</h3>
                <button @click="markAllAsRead()"
                        x-show="unreadCount > 0"
                        class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                    Mark all read
                </button>
            </div>
        </div>

        <!-- Notifications list -->
        <div class="max-h-64 overflow-y-auto">
            <div x-show="loading" class="p-4 text-center text-slate-500">
                <div class="inline-block animate-spin rounded-full h-6 w-6 border-b-2 border-indigo-600"></div>
                <p class="mt-2">Loading notifications...</p>
            </div>

            <div x-show="!loading && notifications.length === 0" class="p-8 text-center text-slate-500">
                <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <p class="font-medium">No notifications</p>
                <p class="text-sm">You're all caught up!</p>
            </div>

            <template x-for="notification in notifications" :key="notification.id">
                <div class="border-b border-slate-100 last:border-b-0">
                    <div class="p-4 hover:bg-slate-50 transition-colors cursor-pointer"
                         @click="if(notification.action_url) { markAsRead(notification.id); window.location.href = notification.action_url; }"
                         :class="{ 'bg-blue-50': !notification.read }">

                        <div class="flex items-start space-x-3">
                            <!-- Notification icon -->
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center"
                                     :class="{
                                         'bg-pink-100': notification.type === 'like',
                                         'bg-blue-100': notification.type === 'comment'
                                     }">
                                    <svg x-show="notification.type === 'like'" class="w-4 h-4 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/>
                                    </svg>
                                    <svg x-show="notification.type === 'comment'" class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>

                            <!-- Notification content -->
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-900" x-text="notification.title"></p>
                                <p class="text-sm text-slate-600" x-text="notification.message"></p>
                                <p class="text-xs text-slate-500 mt-1" x-text="notification.created_at"></p>
                            </div>

                            <!-- Unread indicator -->
                            <div x-show="!notification.read" class="flex-shrink-0">
                                <div class="w-2 h-2 bg-blue-600 rounded-full"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Footer -->
        <div class="p-3 border-t border-slate-200 bg-slate-50">
            <a href="{{ route('notifications.index') }}"
               class="block text-center text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                View all notifications
            </a>
        </div>
    </div>
</div>
