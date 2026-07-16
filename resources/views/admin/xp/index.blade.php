@extends('layouts.admin')

@section('title', 'XP System')

@section('content')
<div class="min-h-screen bg-slate-950 text-slate-100">
    <div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full border border-cyan-500/20 bg-cyan-500/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-cyan-300">
                    <span class="inline-block h-2 w-2 rounded-full bg-cyan-400"></span>
                    XP Administration
                </div>
                <h1 class="mt-3 text-2xl font-semibold tracking-tight text-white sm:text-3xl">XP System</h1>
                <p class="mt-2 max-w-3xl text-sm text-slate-400 sm:text-base">Award or remove XP, review current totals, and audit every change from the log history.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 px-5 py-4 text-sm font-medium text-emerald-300">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="mb-6 rounded-2xl border border-rose-500/20 bg-rose-500/10 px-5 py-4 text-sm font-medium text-rose-300">{{ session('error') }}</div>
        @endif

        <div class="grid gap-6 xl:grid-cols-3">
            <div class="xl:col-span-2 space-y-6">
                <div class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900/80 shadow-2xl shadow-black/20">
                    <div class="border-b border-slate-800 px-6 py-5">
                        <h2 class="text-lg font-semibold text-white">Players</h2>
                        <p class="mt-1 text-sm text-slate-400">Current XP, total earned XP, and quick actions.</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left">
                            <thead class="border-b border-slate-800 bg-slate-950/50 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                                <tr>
                                    <th class="px-6 py-4">Player</th>
                                    <th class="px-6 py-4">Current XP</th>
                                    <th class="px-6 py-4">Total Earned XP</th>
                                    <th class="px-6 py-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800">
                                @foreach($players as $player)
                                    <tr class="bg-slate-900/40">
                                        <td class="px-6 py-5">
                                            <div class="font-semibold text-white">{{ $player->username }}</div>
                                            <div class="mt-1 text-sm text-slate-400">{{ $player->account_code }}</div>
                                        </td>
                                        <td class="px-6 py-5 text-sm text-slate-200">{{ number_format((int) $player->xp) }}</td>
                                        <td class="px-6 py-5 text-sm text-slate-200">{{ number_format((int) $player->total_xp) }}</td>
                                        <td class="px-6 py-5">
                                            <div class="flex flex-wrap gap-2">
                                                <form method="POST" action="{{ route('admin.xp.award', $player) }}" class="flex gap-2">
                                                    @csrf
                                                    <input type="number" name="amount" min="1" required placeholder="XP" class="w-24 rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-slate-100">
                                                    <input type="text" name="reason" required placeholder="Reason" class="w-44 rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-slate-100">
                                                    <button type="submit" class="rounded-lg bg-cyan-500 px-4 py-2 text-sm font-semibold text-slate-950">Award XP</button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.xp.remove', $player) }}" class="flex gap-2">
                                                    @csrf
                                                    <input type="number" name="amount" min="1" required placeholder="XP" class="w-24 rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-slate-100">
                                                    <input type="text" name="reason" required placeholder="Reason" class="w-44 rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-slate-100">
                                                    <button type="submit" class="rounded-lg border border-rose-500/30 bg-rose-500/10 px-4 py-2 text-sm font-semibold text-rose-300">Remove XP</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if(method_exists($players, 'links'))
                        <div class="border-t border-slate-800 px-6 py-4">{{ $players->withQueryString()->links() }}</div>
                    @endif
                </div>
            </div>

            <div class="space-y-6">
                <div class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900/80 shadow-2xl shadow-black/20">
                    <div class="border-b border-slate-800 px-6 py-5">
                        <h2 class="text-lg font-semibold text-white">XP History</h2>
                        <p class="mt-1 text-sm text-slate-400">Latest XP logs with reasons and balances.</p>
                    </div>
                    <div class="divide-y divide-slate-800">
                        @forelse($logs as $log)
                            <div class="px-6 py-4">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <div class="text-sm font-semibold text-white">{{ $log->player?->username ?? 'Unknown Player' }}</div>
                                        <div class="mt-1 text-xs uppercase tracking-[0.18em] text-slate-500">{{ $log->type }} • {{ number_format($log->amount) }} XP</div>
                                    </div>
                                    <div class="text-right text-xs text-slate-500">{{ $log->created_at?->format('Y-m-d H:i') }}</div>
                                </div>
                                <div class="mt-2 text-sm text-slate-300">{{ $log->reason }}</div>
                                @if($log->details)
                                    <div class="mt-1 text-xs text-slate-500">{{ $log->details }}</div>
                                @endif
                            </div>
                        @empty
                            <div class="px-6 py-8 text-sm text-slate-400">No XP logs yet.</div>
                        @endforelse
                    </div>
                    @if(method_exists($logs, 'links'))
                        <div class="border-t border-slate-800 px-6 py-4">{{ $logs->withQueryString()->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection