@extends('layouts.admin')

@section('title','Activity Logs')

@section('content')
<div class="min-h-screen bg-slate-950 text-slate-100">
    <div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full border border-cyan-500/20 bg-cyan-500/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-cyan-300">
                    <span class="inline-block h-2 w-2 rounded-full bg-cyan-400"></span>
                    Admin Monitoring
                </div>
                <h1 class="mt-3 text-2xl font-semibold tracking-tight text-white sm:text-3xl">Activity Logs</h1>
                <p class="mt-2 max-w-3xl text-sm text-slate-400 sm:text-base">
                    Review the complete history of tracked player and system activity across the platform.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.activity-logs.export') }}"
                   class="inline-flex items-center justify-center rounded-xl border border-slate-800 bg-slate-900/80 px-4 py-3 text-sm font-medium text-slate-200 shadow-lg shadow-black/20 transition hover:border-slate-700 hover:bg-slate-800">
                    Export Logs
                </a>

                <form method="POST" action="{{ route('admin.activity-logs.clear') }}" onsubmit="return confirm('Clear all activity logs? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center justify-center rounded-xl border border-rose-500/20 bg-rose-500/10 px-4 py-3 text-sm font-medium text-rose-300 transition hover:border-rose-500/40 hover:bg-rose-500/20">
                        Clear Logs
                    </button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 px-5 py-4 text-sm font-medium text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 rounded-2xl border border-rose-500/20 bg-rose-500/10 px-5 py-4 text-sm font-medium text-rose-300">
                {{ session('error') }}
            </div>
        @endif

        <div class="mb-6 overflow-hidden rounded-3xl border border-slate-800 bg-slate-900/80 shadow-2xl shadow-black/20">
            <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="grid gap-4 p-5 lg:grid-cols-12">
                <div class="relative lg:col-span-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="11" cy="11" r="7"></circle>
                        <path stroke-linecap="round" d="m20 20-3.5-3.5"></path>
                    </svg>
                    <input type="search"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Search player, title, description, type..."
                           class="w-full rounded-xl border border-slate-700 bg-slate-950 py-3 pl-12 pr-4 text-sm text-slate-100 outline-none transition placeholder:text-slate-500 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                </div>

                <div class="lg:col-span-3">
                    <select name="type"
                            class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                        <option value="">All Types</option>
                        @foreach(($types ?? []) as $type)
                            <option value="{{ $type }}" @selected(request('type') === $type)>{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="lg:col-span-2">
                    <input type="date"
                           name="date"
                           value="{{ request('date') }}"
                           class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                </div>

                <div class="flex gap-3 lg:col-span-2">
                    <button type="submit"
                            class="inline-flex flex-1 items-center justify-center rounded-xl bg-cyan-500 px-4 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-400">
                        Filter
                    </button>

                    @if(request('search') || request('type') || request('date'))
                        <a href="{{ route('admin.activity-logs.index') }}"
                           class="inline-flex flex-1 items-center justify-center rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm font-medium text-slate-200 transition hover:border-slate-600 hover:bg-slate-900">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        @if($logs->isEmpty())
            <div class="rounded-3xl border border-dashed border-slate-700 bg-slate-900/70 px-6 py-16 text-center shadow-2xl shadow-black/20">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl border border-cyan-500/20 bg-cyan-500/10 text-cyan-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5M3.75 12h16.5m-16.5 6.75h16.5"/>
                    </svg>
                </div>
                <h2 class="mt-5 text-xl font-semibold text-white">
                    {{ request('search') || request('type') || request('date') ? 'No matching activity logs found' : 'No activity logs available' }}
                </h2>
                <p class="mx-auto mt-2 max-w-md text-sm text-slate-400">
                    {{ request('search') || request('type') || request('date') ? 'Try changing the active filters or clear the current search.' : 'Activity history will appear here when players and administrators perform actions.' }}
                </p>
            </div>
        @else
            <div class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900/80 shadow-2xl shadow-black/20">
                <div class="overflow-x-auto">
                    <table class="min-w-[1100px] w-full text-left">
                        <thead class="border-b border-slate-800 bg-slate-950/50">
                            <tr class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                                <th class="px-6 py-4">Player</th>
                                <th class="px-6 py-4">Type</th>
                                <th class="px-6 py-4">Title</th>
                                <th class="px-6 py-4">Description</th>
                                <th class="px-6 py-4">Date</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @foreach($logs as $log)
                                <tr class="bg-slate-900/40 transition hover:bg-slate-800/50">
                                    <td class="px-6 py-5">
                                        <div class="min-w-[170px]">
                                            <div class="font-semibold text-white">{{ $log->player->account_code ?? 'System' }}</div>
                                            @if(isset($log->player) && $log->player?->username)
                                                <div class="mt-1 text-sm text-slate-400">{{ $log->player->username }}</div>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-5">
                                        <span class="inline-flex rounded-full border border-cyan-500/20 bg-cyan-500/10 px-3 py-1 text-xs font-semibold capitalize text-cyan-300">
                                            {{ $log->type }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-5">
                                        <div class="min-w-[220px] font-medium text-slate-100">
                                            {{ $log->title }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-5">
                                        <div class="max-w-xl text-sm leading-6 text-slate-400">
                                            {{ $log->description ?: 'No description provided.' }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-5">
                                        <div class="min-w-[150px] text-sm text-slate-300">
                                            {{ $log->created_at?->format('Y-m-d H:i') ?? '-' }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-5">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.activity-logs.show', $log) }}"
                                               class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-700 bg-slate-950 text-slate-300 transition hover:border-cyan-500/50 hover:bg-cyan-500/10 hover:text-cyan-300"
                                               title="View Log">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z"/>
                                                    <circle cx="12" cy="12" r="2.25"/>
                                                </svg>
                                            </a>

                                            <form method="POST" action="{{ route('admin.activity-logs.destroy', $log) }}" onsubmit="return confirm('Delete this activity log?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-700 bg-slate-950 text-slate-300 transition hover:border-rose-500/50 hover:bg-rose-500/10 hover:text-rose-300"
                                                        title="Delete Log">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9 14.394 18m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673A2.25 2.25 0 0 1 15.916 21.75H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0V4.875c0-1.242-.987-2.25-2.25-2.25h-3c-1.263 0-2.25 1.008-2.25 2.25v.918m7.5 0a45.668 45.668 0 0 0-7.5 0"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if(method_exists($logs, 'links'))
                    <div class="border-t border-slate-800 px-6 py-4">
                        {{ $logs->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection