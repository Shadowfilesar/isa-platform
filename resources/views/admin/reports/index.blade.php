@extends('layouts.admin')

@section('title','Reports')

@section('content')
<div class="min-h-screen bg-slate-950 text-slate-100">
    <div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full border border-cyan-500/20 bg-cyan-500/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-cyan-300">
                    <span class="inline-block h-2 w-2 rounded-full bg-cyan-400"></span>
                    Admin Reports
                </div>
                <h1 class="mt-3 text-2xl font-semibold tracking-tight text-white sm:text-3xl">Reports</h1>
                <p class="mt-2 max-w-3xl text-sm text-slate-400 sm:text-base">
                    Review platform-wide metrics, inspect operational totals, and export intelligence summaries from the admin panel.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.reports.statistics') }}"
                   class="inline-flex items-center justify-center rounded-xl border border-slate-800 bg-slate-900/80 px-4 py-3 text-sm font-medium text-slate-200 shadow-lg shadow-black/20 transition hover:border-slate-700 hover:bg-slate-800">
                    Open Statistics
                </a>
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

        <div class="mb-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-5 shadow-2xl shadow-black/20">
                <div class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Players</div>
                <div class="mt-3 text-3xl font-semibold text-white">{{ number_format((int) ($stats['players'] ?? 0)) }}</div>
                <div class="mt-2 text-sm text-slate-400">Registered investigation accounts</div>
            </div>

            <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-5 shadow-2xl shadow-black/20">
                <div class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Cases</div>
                <div class="mt-3 text-3xl font-semibold text-white">{{ number_format((int) ($stats['cases'] ?? 0)) }}</div>
                <div class="mt-2 text-sm text-slate-400">Active and archived case records</div>
            </div>

            <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-5 shadow-2xl shadow-black/20">
                <div class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Notifications</div>
                <div class="mt-3 text-3xl font-semibold text-white">{{ number_format((int) ($stats['notifications'] ?? 0)) }}</div>
                <div class="mt-2 text-sm text-slate-400">System and mission notices</div>
            </div>

            <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-5 shadow-2xl shadow-black/20">
                <div class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Activity Logs</div>
                <div class="mt-3 text-3xl font-semibold text-white">{{ number_format((int) ($stats['activity_logs'] ?? 0)) }}</div>
                <div class="mt-2 text-sm text-slate-400">Tracked operational events</div>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-3">
            <div class="xl:col-span-2">
                <div class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900/80 shadow-2xl shadow-black/20">
                    <div class="border-b border-slate-800 px-6 py-5">
                        <h2 class="text-lg font-semibold text-white">Export Center</h2>
                        <p class="mt-1 text-sm text-slate-400">
                            Download structured exports for administrative review and operational reporting.
                        </p>
                    </div>

                    <div class="grid gap-4 p-6 md:grid-cols-2">
                        <a href="{{ route('admin.reports.export', 'players') }}"
                           class="group rounded-2xl border border-slate-800 bg-slate-950/70 p-5 transition hover:border-cyan-500/30 hover:bg-cyan-500/5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <div class="text-base font-semibold text-white">Players Export</div>
                                    <div class="mt-2 text-sm text-slate-400">Download player records for review, audits, and external analysis.</div>
                                </div>
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-cyan-500/20 bg-cyan-500/10 text-cyan-300 transition group-hover:scale-105">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0 4-4m-4 4-4-4M4 17.25V18a2.25 2.25 0 0 0 2.25 2.25h11.5A2.25 2.25 0 0 0 20 18v-.75"/>
                                    </svg>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('admin.reports.export', 'cases') }}"
                           class="group rounded-2xl border border-slate-800 bg-slate-950/70 p-5 transition hover:border-cyan-500/30 hover:bg-cyan-500/5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <div class="text-base font-semibold text-white">Cases Export</div>
                                    <div class="mt-2 text-sm text-slate-400">Export case records for operational monitoring and archival work.</div>
                                </div>
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-cyan-500/20 bg-cyan-500/10 text-cyan-300 transition group-hover:scale-105">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0 4-4m-4 4-4-4M4 17.25V18a2.25 2.25 0 0 0 2.25 2.25h11.5A2.25 2.25 0 0 0 20 18v-.75"/>
                                    </svg>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('admin.reports.export', 'notifications') }}"
                           class="group rounded-2xl border border-slate-800 bg-slate-950/70 p-5 transition hover:border-cyan-500/30 hover:bg-cyan-500/5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <div class="text-base font-semibold text-white">Notifications Export</div>
                                    <div class="mt-2 text-sm text-slate-400">Extract notification records for message tracking and compliance.</div>
                                </div>
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-cyan-500/20 bg-cyan-500/10 text-cyan-300 transition group-hover:scale-105">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0 4-4m-4 4-4-4M4 17.25V18a2.25 2.25 0 0 0 2.25 2.25h11.5A2.25 2.25 0 0 0 20 18v-.75"/>
                                    </svg>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('admin.reports.export', 'activity_logs') }}"
                           class="group rounded-2xl border border-slate-800 bg-slate-950/70 p-5 transition hover:border-cyan-500/30 hover:bg-cyan-500/5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <div class="text-base font-semibold text-white">Activity Logs Export</div>
                                    <div class="mt-2 text-sm text-slate-400">Download operational activity history for review and incident tracing.</div>
                                </div>
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-cyan-500/20 bg-cyan-500/10 text-cyan-300 transition group-hover:scale-105">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0 4-4m-4 4-4-4M4 17.25V18a2.25 2.25 0 0 0 2.25 2.25h11.5A2.25 2.25 0 0 0 20 18v-.75"/>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900/80 shadow-2xl shadow-black/20">
                    <div class="border-b border-slate-800 px-6 py-5">
                        <h2 class="text-lg font-semibold text-white">Quick Links</h2>
                        <p class="mt-1 text-sm text-slate-400">
                            Open related admin areas without leaving the reporting workflow.
                        </p>
                    </div>

                    <div class="space-y-3 p-6">
                        <a href="{{ route('admin.players.index') }}"
                           class="flex items-center justify-between rounded-2xl border border-slate-800 bg-slate-950/70 px-4 py-3 text-sm font-medium text-slate-200 transition hover:border-slate-700 hover:bg-slate-900">
                            <span>Players</span>
                            <span class="text-slate-500">→</span>
                        </a>

                        <a href="{{ route('admin.cases.index') }}"
                           class="flex items-center justify-between rounded-2xl border border-slate-800 bg-slate-950/70 px-4 py-3 text-sm font-medium text-slate-200 transition hover:border-slate-700 hover:bg-slate-900">
                            <span>Cases</span>
                            <span class="text-slate-500">→</span>
                        </a>

                        <a href="{{ route('admin.notifications.index') }}"
                           class="flex items-center justify-between rounded-2xl border border-slate-800 bg-slate-950/70 px-4 py-3 text-sm font-medium text-slate-200 transition hover:border-slate-700 hover:bg-slate-900">
                            <span>Notifications</span>
                            <span class="text-slate-500">→</span>
                        </a>

                        <a href="{{ route('admin.activity-logs.index') }}"
                           class="flex items-center justify-between rounded-2xl border border-slate-800 bg-slate-950/70 px-4 py-3 text-sm font-medium text-slate-200 transition hover:border-slate-700 hover:bg-slate-900">
                            <span>Activity Logs</span>
                            <span class="text-slate-500">→</span>
                        </a>

                        <a href="{{ route('admin.settings.index') }}"
                           class="flex items-center justify-between rounded-2xl border border-slate-800 bg-slate-950/70 px-4 py-3 text-sm font-medium text-slate-200 transition hover:border-slate-700 hover:bg-slate-900">
                            <span>Settings</span>
                            <span class="text-slate-500">→</span>
                        </a>
                    </div>
                </div>

                <div class="overflow-hidden rounded-3xl border border-slate-800 bg-gradient-to-br from-cyan-500/10 via-slate-900 to-slate-900 shadow-2xl shadow-black/20">
                    <div class="px-6 py-5">
                        <h2 class="text-lg font-semibold text-white">Report Status</h2>
                        <p class="mt-1 text-sm text-slate-300">
                            Reporting tools are active and available for administrative operations.
                        </p>
                    </div>

                    <div class="space-y-3 px-6 pb-6 text-sm text-slate-300">
                        <div class="rounded-2xl border border-cyan-500/20 bg-cyan-500/10 px-4 py-3">
                            Export endpoints are ready for authorized admin use.
                        </div>
                        <div class="rounded-2xl border border-slate-800 bg-slate-950/70 px-4 py-3 text-slate-400">
                            Use the statistics page for expanded operational analysis.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection