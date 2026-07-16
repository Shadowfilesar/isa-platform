@php
    $player = $player ?? request()->attributes->get('player');
@endphp

<header class="border-b border-slate-800 bg-slate-950/95 backdrop-blur">
    <div class="mx-auto flex w-full max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
        <div class="flex min-w-0 items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl border border-amber-500/20 bg-amber-500/10 text-amber-400 shadow-lg shadow-black/20">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M12 3l7 4v5c0 5-3.5 8.5-7 9-3.5-.5-7-4-7-9V7l7-4z"></path>
                    <path d="M10 12l1.5 1.5L15 10"></path>
                </svg>
            </div>

            <div class="min-w-0">
                <div class="text-[11px] font-semibold uppercase tracking-[0.22em] text-slate-500">
                    Investigation Command
                </div>
                <div class="truncate text-sm font-semibold text-white sm:text-base">
                    Interactive Detective Platform
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('notifications.index') }}"
               class="relative inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-800 bg-slate-900 text-slate-300 transition hover:border-slate-700 hover:bg-slate-800 hover:text-white"
               aria-label="Notifications">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2a2 2 0 0 1-.6 1.4L4 17h5"></path>
                    <path d="M9 17a3 3 0 0 0 6 0"></path>
                </svg>
            </a>

            <div class="flex items-center gap-3 rounded-2xl border border-slate-800 bg-slate-900 px-3 py-2.5 shadow-lg shadow-black/10">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-cyan-500 to-blue-600 text-sm font-bold text-white">
                    {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($player->name ?? 'P', 0, 1)) }}
                </div>

                <div class="hidden min-w-0 sm:block">
                    <div class="truncate text-sm font-semibold text-white">
                        {{ $player->name ?? 'Player' }}
                    </div>
                    <div class="truncate text-xs text-slate-400">
                        {{ $player->email ?? ($player->account_code ?? 'Active Agent') }}
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center rounded-xl border border-slate-700 bg-slate-950 px-3 py-2 text-xs font-semibold uppercase tracking-[0.18em] text-slate-300 transition hover:border-rose-500/30 hover:bg-rose-500/10 hover:text-rose-300">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
