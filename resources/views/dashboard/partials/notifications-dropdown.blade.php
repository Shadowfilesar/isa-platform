@php
    $player = request()->attributes->get('player');

    $notifications = collect();
    $unread = 0;

    if ($player) {
        $notifications = $player->notifications()
            ->latest()
            ->take(8)
            ->get();

        $unread = $player->notifications()
            ->where('is_read', false)
            ->count();
    }
@endphp

<div
    x-data="{ open:false }"
    class="relative">

    <button
        @click="open=!open"
        class="relative flex h-11 w-11 items-center justify-center rounded-lg border border-slate-700 bg-slate-900 hover:bg-slate-800 transition">

        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5 text-white"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor">

            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 17h5l-1.4-1.4A2 2 0 0118 14.17V11a6 6 0 10-12 0v3.17c0 .53-.21 1.04-.59 1.42L4 17h5m6 0a3 3 0 11-6 0h6z"/>
        </svg>

        @if($unread)
            <span
                class="absolute -top-1 -right-1 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-red-600 px-1 text-[11px] font-bold text-white">
                {{ $unread }}
            </span>
        @endif

    </button>

    <div
        x-show="open"
        @click.outside="open=false"
        x-transition
        class="absolute right-0 mt-3 w-96 overflow-hidden rounded-xl border border-slate-700 bg-[#111827] shadow-2xl z-50">

        <div class="border-b border-slate-700 px-5 py-4">

            <div class="flex items-center justify-between">

                <h3 class="text-lg font-semibold text-white">
                    Notifications
                </h3>

                @if($unread)
                    <span class="rounded-full bg-red-700 px-3 py-1 text-xs text-white">
                        {{ $unread }} Unread
                    </span>
                @endif

            </div>

        </div>

        @if($notifications->isEmpty())

            <div class="px-6 py-10 text-center text-slate-500">
                No notifications found.
            </div>

        @else

            <div class="max-h-96 overflow-y-auto">

                @foreach($notifications as $notification)

                    <a
                        href="{{ route('messages.index') }}"
                        class="block border-b border-slate-800 px-5 py-4 transition hover:bg-slate-800">

                        <div class="flex items-start justify-between gap-4">

                            <div class="flex-1">

                                <div class="font-semibold text-white">

                                    {{ $notification->title }}

                                </div>

                                <div class="mt-2 text-sm text-slate-400">

                                    {{ $notification->message }}

                                </div>

                                <div class="mt-3 text-xs text-slate-500">

                                    {{ $notification->created_at?->diffForHumans() }}

                                </div>

                            </div>

                            @if(!$notification->is_read)

                                <span class="mt-2 h-3 w-3 rounded-full bg-red-500"></span>

                            @endif

                        </div>

                    </a>

                @endforeach

            </div>

        @endif

        <div class="border-t border-slate-700">

            <a
                href="{{ route('messages.index') }}"
                class="block px-5 py-4 text-center text-amber-400 hover:bg-slate-800">

                Open Director Inbox

            </a>

        </div>

    </div>

</div>