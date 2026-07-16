@extends('layouts.admin')

@section('title','ISA Personnel File')

@section('content')
<div class="min-h-screen bg-slate-950 text-slate-100">
    <div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full border border-cyan-500/20 bg-cyan-500/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-cyan-300">
                    <span class="inline-block h-2 w-2 rounded-full bg-cyan-400"></span>
                    ISA Personnel File
                </div>
                <h1 class="mt-3 text-2xl font-semibold tracking-tight text-white sm:text-3xl">Agent Personnel Record</h1>
                <p class="mt-2 max-w-3xl text-sm text-slate-400 sm:text-base">
                    Official ISA personnel file for identity, progression, access level, and operational assignment review.
                </p>
            </div>

            <a href="{{ route('admin.players.index') }}"
               class="inline-flex items-center justify-center rounded-xl border border-slate-800 bg-slate-900/80 px-4 py-2.5 text-sm font-medium text-slate-200 shadow-lg shadow-black/20 transition hover:border-slate-700 hover:bg-slate-800">
                Back to Players
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 px-5 py-4 text-sm font-medium text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 rounded-2xl border border-rose-500/20 bg-rose-500/10 px-5 py-4 text-sm font-medium text-rose-300">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-rose-500/20 bg-rose-500/10 px-5 py-4 text-sm text-rose-300">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid gap-6 xl:grid-cols-3">
            <div class="space-y-6 xl:col-span-2">
                <div class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900/80 shadow-2xl shadow-black/20">
                    <div class="border-b border-slate-800 px-6 py-5">
                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h2 class="text-lg font-semibold text-white">Identity & Access</h2>
                                <p class="mt-1 text-sm text-slate-400">Core personnel identity and agency access data.</p>
                            </div>
                            <div class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] {{ $player->status === 'active' ? 'border-emerald-500/30 bg-emerald-500/10 text-emerald-300' : 'border-rose-500/30 bg-rose-500/10 text-rose-300' }}">
                                {{ $player->status === 'active' ? 'Active Personnel' : 'Inactive Personnel' }}
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.players.update', $player) }}" class="grid gap-6 p-6 md:grid-cols-2">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="account_code" class="mb-2 block text-sm font-medium text-slate-200">Agent Code</label>
                            <input id="account_code" name="account_code" type="text" value="{{ old('account_code', $player->account_code) }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                        </div>

                        <div>
                            <label for="username" class="mb-2 block text-sm font-medium text-slate-200">Username</label>
                            <input id="username" name="username" type="text" value="{{ old('username', $player->username) }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                        </div>

                        <div>
                            <label for="rank" class="mb-2 block text-sm font-medium text-slate-200">Rank</label>
                            <input id="rank" name="rank" type="text" value="{{ $player->rank }}" readonly class="w-full rounded-xl border border-slate-800 bg-slate-900/60 px-4 py-3 text-sm text-slate-300 outline-none">
                        </div>

                        <div>
                            <label for="clearance_level" class="mb-2 block text-sm font-medium text-slate-200">Clearance Level</label>
                            <select id="clearance_level" name="clearance_level" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                                <option value="">No Clearance</option>
                                @foreach ($clearanceLevels as $clearanceLevel)
                                    <option value="{{ $clearanceLevel }}" @selected(old('clearance_level', $player->clearance_level) === $clearanceLevel)>
                                        {{ $clearanceLevel }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="level_display" class="mb-2 block text-sm font-medium text-slate-200">Current Level</label>
                            <input id="level_display" type="text" value="Level {{ $currentLevel }}" readonly class="w-full rounded-xl border border-slate-800 bg-slate-900/60 px-4 py-3 text-sm text-slate-300 outline-none">
                        </div>

                        <div>
                            <label for="status_display" class="mb-2 block text-sm font-medium text-slate-200">Status</label>
                            <div class="flex h-[50px] items-center rounded-xl border border-slate-800 bg-slate-900/60 px-4 text-sm text-slate-300">
                                {{ $player->status === 'active' ? 'Active' : 'Inactive' }}
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label for="password" class="mb-2 block text-sm font-medium text-slate-200">Password</label>
                            <input id="password" name="password" type="password" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                        </div>

                        <div class="md:col-span-2">
                            <input type="hidden" name="status" value="inactive">
                            <label class="flex items-start gap-4 rounded-2xl border border-slate-800 bg-slate-950/70 p-4 transition hover:border-slate-700">
                                <input type="checkbox"
                                       name="status"
                                       value="active"
                                       @checked(old('status', $player->status) === 'active')
                                       class="mt-1 h-4 w-4 rounded border-slate-600 bg-slate-900 text-cyan-500 focus:ring-cyan-500/30">
                                <div>
                                    <div class="text-sm font-semibold text-white">Active Personnel Status</div>
                                    <div class="mt-1 text-sm text-slate-400">Enable or suspend agency access for this personnel record.</div>
                                </div>
                            </label>
                        </div>

                        <div class="md:col-span-2 flex flex-wrap gap-3">
                            <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-cyan-500 px-4 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-400">
                                Save Personnel File
                            </button>

                            <a href="{{ route('admin.players.assign-cases', $player) }}"
                               class="inline-flex items-center justify-center rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm font-semibold text-slate-200 transition hover:border-cyan-500/40 hover:bg-cyan-500/10 hover:text-cyan-300">
                                Manage Assigned Cases
                            </a>
                        </div>
                    </form>
                </div>

                <div class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900/80 shadow-2xl shadow-black/20">
                    <div class="border-b border-slate-800 px-6 py-5">
                        <h2 class="text-lg font-semibold text-white">Progress & Classification</h2>
                        <p class="mt-1 text-sm text-slate-400">Live operational progression using the existing XP, rank, and clearance systems.</p>
                    </div>

                    <div class="grid gap-6 p-6 lg:grid-cols-2">
                        <div class="rounded-2xl border border-slate-800 bg-slate-950/70 p-5 lg:col-span-2">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <div class="text-sm uppercase tracking-[0.18em] text-slate-500">XP Progress</div>
                                    <div class="mt-2 text-2xl font-semibold text-white">
                                        {{ number_format($currentXp) }} XP
                                    </div>
                                    <div class="mt-1 text-sm text-slate-400">
                                        {{ number_format($xpIntoLevel) }} / {{ number_format($xpRequiredForNextLevel) }} XP toward next level
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-3 sm:grid-cols-3 text-center">
                                    <div class="rounded-2xl border border-slate-800 bg-slate-900/70 px-4 py-3">
                                        <div class="text-[11px] uppercase tracking-[0.18em] text-slate-500">Level</div>
                                        <div class="mt-1 text-lg font-semibold text-white">{{ $currentLevel }}</div>
                                    </div>
                                    <div class="rounded-2xl border border-slate-800 bg-slate-900/70 px-4 py-3">
                                        <div class="text-[11px] uppercase tracking-[0.18em] text-slate-500">Rank</div>
                                        <div class="mt-1 text-sm font-semibold text-cyan-300">{{ $player->rank }}</div>
                                    </div>
                                    <div class="rounded-2xl border border-slate-800 bg-slate-900/70 px-4 py-3">
                                        <div class="text-[11px] uppercase tracking-[0.18em] text-slate-500">Clearance</div>
                                        <div class="mt-1 text-sm font-semibold text-amber-300">{{ $player->clearance_level ?: 'None' }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5">
                                <div class="h-3 w-full overflow-hidden rounded-full bg-slate-800">
                                    <div class="h-full rounded-full bg-gradient-to-r from-cyan-500 via-sky-400 to-emerald-400" style="width: {{ $xpProgressPercent }}%;"></div>
                                </div>
                                <div class="mt-2 flex items-center justify-between gap-3 text-[11px] text-slate-500">
                                    <span>{{ number_format($currentLevelFloorXp) }} XP</span>
                                    <span class="text-center">{{ $xpProgressPercent }}% complete</span>
                                    <span>{{ number_format($nextLevelFloorXp) }} XP</span>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-slate-800 bg-slate-950/70 p-5">
                            <div class="text-sm uppercase tracking-[0.18em] text-slate-500">Current XP</div>
                            <div class="mt-2 text-3xl font-semibold text-white">{{ number_format((int) $player->xp) }}</div>
                            <div class="mt-2 text-xs text-slate-500">Available operational XP.</div>
                        </div>

                        <div class="rounded-2xl border border-slate-800 bg-slate-950/70 p-5">
                            <div class="text-sm uppercase tracking-[0.18em] text-slate-500">Total Earned XP</div>
                            <div class="mt-2 text-3xl font-semibold text-white">{{ number_format((int) $player->total_xp) }}</div>
                            <div class="mt-2 text-xs text-slate-500">Lifetime earned XP record.</div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900/80 shadow-2xl shadow-black/20">
                    <div class="border-b border-slate-800 px-6 py-5">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h2 class="text-lg font-semibold text-white">Achievements</h2>
                                <p class="mt-1 text-sm text-slate-400">Unlocked and locked achievement records from the ISA progression system.</p>
                            </div>
                            <div class="inline-flex items-center rounded-full border border-cyan-500/20 bg-cyan-500/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-cyan-300">
                                {{ $playerAchievements->count() }} / {{ $allAchievements->count() }} unlocked
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="grid gap-6 xl:grid-cols-2">
                            <div>
                                <div class="mb-4 flex items-center justify-between">
                                    <h3 class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-500">Earned Achievements</h3>
                                    <span class="text-xs text-slate-500">Visible in personnel file</span>
                                </div>

                                <div class="space-y-3">
                                    @forelse($playerAchievements as $playerAchievement)
                                        <div class="rounded-2xl border border-emerald-500/15 bg-emerald-500/5 px-4 py-4">
                                            <div class="flex items-start justify-between gap-4">
                                                <div class="min-w-0">
                                                    <div class="flex items-center gap-2">
                                                        <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl border border-emerald-500/20 bg-emerald-500/10 text-sm font-bold text-emerald-300">
                                                            {{ strtoupper(substr($playerAchievement->achievement->name, 0, 1)) }}
                                                        </span>
                                                        <div class="min-w-0">
                                                            <div class="truncate text-sm font-semibold text-white">
                                                                {{ $playerAchievement->achievement->name }}
                                                            </div>
                                                            <div class="mt-0.5 text-xs text-slate-400">
                                                                {{ $playerAchievement->achievement->description }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="shrink-0 text-right">
                                                    <div class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-300">
                                                        +{{ number_format((int) $playerAchievement->achievement->xp_reward) }} XP
                                                    </div>
                                                    <div class="mt-1 text-xs text-slate-500">
                                                        {{ optional($playerAchievement->earned_at)->format('Y-m-d') ?? '—' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="rounded-2xl border border-dashed border-slate-700 bg-slate-950/50 px-4 py-10 text-center text-sm text-slate-400">
                                            No achievements unlocked yet.
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <div>
                                <div class="mb-4 flex items-center justify-between">
                                    <h3 class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-500">Locked Achievements</h3>
                                    <span class="text-xs text-slate-500">Future objectives</span>
                                </div>

                                <div class="space-y-3">
                                    @forelse($lockedAchievements as $achievement)
                                        <div class="rounded-2xl border border-slate-800 bg-slate-950/60 px-4 py-4 opacity-90">
                                            <div class="flex items-start justify-between gap-4">
                                                <div class="min-w-0">
                                                    <div class="flex items-center gap-2">
                                                        <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl border border-slate-700 bg-slate-900 text-sm font-bold text-slate-400">
                                                            ?
                                                        </span>
                                                        <div class="min-w-0">
                                                            <div class="truncate text-sm font-semibold text-white">
                                                                {{ $achievement->hidden ? 'Classified Achievement' : $achievement->name }}
                                                            </div>
                                                            <div class="mt-0.5 text-xs text-slate-500">
                                                                {{ $achievement->hidden ? 'Unlock requirements remain classified.' : $achievement->description }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="shrink-0 text-right">
                                                    <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">
                                                        +{{ number_format((int) $achievement->xp_reward) }} XP
                                                    </div>
                                                    <div class="mt-1 text-xs text-slate-600">
                                                        Locked
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="rounded-2xl border border-dashed border-slate-700 bg-slate-950/50 px-4 py-10 text-center text-sm text-slate-400">
                                            All achievements unlocked.
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900/80 shadow-2xl shadow-black/20">
                    <div class="border-b border-slate-800 px-6 py-5">
                        <h2 class="text-lg font-semibold text-white">XP History</h2>
                        <p class="mt-1 text-sm text-slate-400">Chronological progression log from the existing XP system.</p>
                    </div>

                    <div class="px-6 py-5">
                        <div class="mb-4 grid gap-4 md:grid-cols-3">
                            <div class="rounded-2xl border border-slate-800 bg-slate-950/70 px-4 py-4">
                                <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Current Level</div>
                                <div class="mt-2 text-2xl font-semibold text-white">Level {{ $currentLevel }}</div>
                            </div>
                            <div class="rounded-2xl border border-slate-800 bg-slate-950/70 px-4 py-4">
                                <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Current Rank</div>
                                <div class="mt-2 text-2xl font-semibold text-cyan-300">{{ $player->rank }}</div>
                            </div>
                            <div class="rounded-2xl border border-slate-800 bg-slate-950/70 px-4 py-4">
                                <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Total Entries</div>
                                <div class="mt-2 text-2xl font-semibold text-white">{{ $player->xpLogs->count() }}</div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            @forelse($player->xpLogs as $log)
                                <div class="rounded-2xl border border-slate-800 bg-slate-950/70 px-4 py-4">
                                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                                        <div>
                                            <div class="flex flex-wrap items-center gap-2">
                                                <span class="inline-flex items-center rounded-full border px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] {{ $log->type === 'award' ? 'border-emerald-500/30 bg-emerald-500/10 text-emerald-300' : 'border-rose-500/30 bg-rose-500/10 text-rose-300' }}">
                                                    {{ $log->type === 'award' ? 'Award' : 'Remove' }}
                                                </span>
                                                <span class="text-sm font-semibold text-white">{{ $log->reason }}</span>
                                            </div>

                                            @if ($log->details)
                                                <p class="mt-2 text-sm text-slate-400">{{ $log->details }}</p>
                                            @endif

                                            <div class="mt-3 flex flex-wrap gap-4 text-xs text-slate-500">
                                                <span>By: {{ $log->admin?->username ?? 'System' }}</span>
                                                <span>Before: {{ number_format((int) $log->balance_before) }} XP</span>
                                                <span>After: {{ number_format((int) $log->balance_after) }} XP</span>
                                            </div>
                                        </div>

                                        <div class="text-left lg:text-right">
                                            <div class="text-lg font-semibold {{ $log->type === 'award' ? 'text-emerald-300' : 'text-rose-300' }}">
                                                {{ $log->type === 'award' ? '+' : '-' }}{{ number_format((int) $log->amount) }} XP
                                            </div>
                                            <div class="mt-1 text-xs text-slate-500">
                                                {{ $log->created_at?->format('Y-m-d H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="rounded-2xl border border-dashed border-slate-700 bg-slate-950/50 px-4 py-10 text-center text-sm text-slate-400">
                                    No XP history available for this personnel file.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-3xl border border-dashed border-slate-800 bg-slate-900/50 shadow-2xl shadow-black/10">
                    <div class="border-b border-slate-800 px-6 py-5">
                        <h2 class="text-lg font-semibold text-white">Reserved Modules</h2>
                        <p class="mt-1 text-sm text-slate-400">Prepared layout zones for future personnel expansion.</p>
                    </div>

                    <div class="grid gap-4 p-6 md:grid-cols-2">
                        <div class="rounded-2xl border border-dashed border-slate-700 bg-slate-950/40 px-4 py-5">
                            <div class="text-sm font-semibold text-white">Medals</div>
                            <div class="mt-1 text-sm text-slate-500">Reserved for future commendation records.</div>
                        </div>
                        <div class="rounded-2xl border border-dashed border-slate-700 bg-slate-950/40 px-4 py-5">
                            <div class="text-sm font-semibold text-white">Activity Timeline</div>
                            <div class="mt-1 text-sm text-slate-500">Reserved for future personnel timeline events.</div>
                        </div>
                        <div class="rounded-2xl border border-dashed border-slate-700 bg-slate-950/40 px-4 py-5 md:col-span-2">
                            <div class="text-sm font-semibold text-white">Investigation Statistics</div>
                            <div class="mt-1 text-sm text-slate-500">Reserved for future operational metrics.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="overflow-hidden rounded-3xl border border-cyan-500/20 bg-gradient-to-br from-slate-900 via-slate-900 to-cyan-950/30 shadow-2xl shadow-black/20">
                    <div class="border-b border-slate-800/80 px-6 py-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-lg font-semibold text-white">ISA Personnel Card</h2>
                                <p class="mt-1 text-sm text-slate-400">Agency identity summary.</p>
                            </div>
                            <div class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-cyan-500/20 bg-cyan-500/10 text-cyan-300">
                                ISA
                            </div>
                        </div>
                    </div>

                    <div class="space-y-5 px-6 py-6">
                        <div>
                            <div class="text-xs uppercase tracking-[0.22em] text-slate-500">Agent Code</div>
                            <div class="mt-2 text-2xl font-semibold text-white">{{ $player->account_code }}</div>
                            <div class="mt-1 text-sm text-slate-400">{{ $player->username }}</div>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] {{ $player->status === 'active' ? 'border-emerald-500/30 bg-emerald-500/10 text-emerald-300' : 'border-rose-500/30 bg-rose-500/10 text-rose-300' }}">
                                {{ $player->status === 'active' ? 'Active' : 'Inactive' }}
                            </span>
                            <span class="inline-flex items-center rounded-full border border-cyan-500/30 bg-cyan-500/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-cyan-300">
                                {{ $player->rank }}
                            </span>
                            <span class="inline-flex items-center rounded-full border border-amber-500/30 bg-amber-500/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-amber-300">
                                {{ $player->clearance_level ?: 'No Clearance' }}
                            </span>
                        </div>

                        <div class="grid gap-3 sm:grid-cols-2">
                            <div class="rounded-2xl border border-slate-800 bg-slate-950/50 px-4 py-4">
                                <div class="text-[11px] uppercase tracking-[0.18em] text-slate-500">Current Level</div>
                                <div class="mt-2 text-xl font-semibold text-white">{{ $currentLevel }}</div>
                            </div>
                            <div class="rounded-2xl border border-slate-800 bg-slate-950/50 px-4 py-4">
                                <div class="text-[11px] uppercase tracking-[0.18em] text-slate-500">Current XP</div>
                                <div class="mt-2 text-xl font-semibold text-white">{{ number_format((int) $player->xp) }}</div>
                            </div>
                            <div class="rounded-2xl border border-slate-800 bg-slate-950/50 px-4 py-4">
                                <div class="text-[11px] uppercase tracking-[0.18em] text-slate-500">Total Earned XP</div>
                                <div class="mt-2 text-xl font-semibold text-white">{{ number_format((int) $player->total_xp) }}</div>
                            </div>
                            <div class="rounded-2xl border border-slate-800 bg-slate-950/50 px-4 py-4">
                                <div class="text-[11px] uppercase tracking-[0.18em] text-slate-500">Achievements</div>
                                <div class="mt-2 text-xl font-semibold text-white">{{ $playerAchievements->count() }}</div>
                            </div>
                            <div class="rounded-2xl border border-slate-800 bg-slate-950/50 px-4 py-4 sm:col-span-2">
                                <div class="text-[11px] uppercase tracking-[0.18em] text-slate-500">Assigned Cases</div>
                                <div class="mt-2 text-xl font-semibold text-white">{{ $player->cases->count() }}</div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-slate-800 bg-slate-950/50 px-4 py-4">
                            <div class="flex items-center justify-between text-xs uppercase tracking-[0.18em] text-slate-500">
                                <span>Progress to next level</span>
                                <span>{{ $xpProgressPercent }}%</span>
                            </div>
                            <div class="mt-3 h-2.5 w-full overflow-hidden rounded-full bg-slate-800">
                                <div class="h-full rounded-full bg-gradient-to-r from-cyan-500 via-sky-400 to-emerald-400" style="width: {{ $xpProgressPercent }}%;"></div>
                            </div>
                            <div class="mt-3 flex flex-col gap-1 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between">
                                <span>{{ number_format($xpIntoLevel) }} XP earned in current level</span>
                                <span>{{ number_format($xpRequiredForNextLevel) }} XP required</span>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-slate-800 bg-slate-950/50 px-4 py-4">
                            <div class="mb-3 flex items-center justify-between">
                                <div class="text-[11px] uppercase tracking-[0.18em] text-slate-500">Recent Achievements</div>
                                <div class="text-xs text-slate-500">{{ $playerAchievements->count() }} unlocked</div>
                            </div>

                            <div class="space-y-2">
                                @forelse($playerAchievements->take(3) as $playerAchievement)
                                    <div class="flex items-center justify-between gap-3 rounded-xl border border-slate-800 bg-slate-900/60 px-3 py-2">
                                        <div class="min-w-0">
                                            <div class="truncate text-sm font-medium text-white">{{ $playerAchievement->achievement->name }}</div>
                                            <div class="text-xs text-slate-500">{{ optional($playerAchievement->earned_at)->format('Y-m-d') ?? '—' }}</div>
                                        </div>
                                        <div class="shrink-0 text-xs font-semibold text-emerald-300">
                                            +{{ number_format((int) $playerAchievement->achievement->xp_reward) }} XP
                                        </div>
                                    </div>
                                @empty
                                    <div class="rounded-xl border border-dashed border-slate-700 bg-slate-900/40 px-3 py-4 text-center text-sm text-slate-400">
                                        No achievements yet.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="space-y-3 border-t border-slate-800 pt-5 text-sm">
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-slate-500">Last Login</span>
                                <span class="text-right font-medium text-white">{{ optional($player->last_login)->format('Y-m-d H:i') ?? 'Never' }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-slate-500">Account Created</span>
                                <span class="text-right font-medium text-white">{{ optional($player->created_at)->format('Y-m-d H:i') ?? '—' }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-slate-500">Personnel Record</span>
                                <span class="text-right font-medium text-cyan-300">Active in ISA Registry</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900/80 shadow-2xl shadow-black/20">
                    <div class="border-b border-slate-800 px-6 py-5">
                        <h2 class="text-lg font-semibold text-white">Personnel Snapshot</h2>
                        <p class="mt-1 text-sm text-slate-400">Operational identity overview.</p>
                    </div>

                    <div class="space-y-4 px-6 py-5 text-sm">
                        <div class="rounded-2xl border border-slate-800 bg-slate-950/70 px-4 py-3">
                            <div class="text-slate-500">Agent Code</div>
                            <div class="mt-1 font-medium text-white">{{ $player->account_code }}</div>
                        </div>

                        <div class="rounded-2xl border border-slate-800 bg-slate-950/70 px-4 py-3">
                            <div class="text-slate-500">Username</div>
                            <div class="mt-1 font-medium text-white">{{ $player->username }}</div>
                        </div>

                        <div class="rounded-2xl border border-slate-800 bg-slate-950/70 px-4 py-3">
                            <div class="text-slate-500">Status</div>
                            <div class="mt-1 font-medium text-white">{{ $player->status === 'active' ? 'Active' : 'Inactive' }}</div>
                        </div>

                        <div class="rounded-2xl border border-slate-800 bg-slate-950/70 px-4 py-3">
                            <div class="text-slate-500">Rank</div>
                            <div class="mt-1 font-medium text-white">{{ $player->rank ?: '—' }}</div>
                        </div>

                        <div class="rounded-2xl border border-slate-800 bg-slate-950/70 px-4 py-3">
                            <div class="text-slate-500">Clearance Level</div>
                            <div class="mt-1 font-medium text-white">{{ $player->clearance_level ?: 'No Clearance' }}</div>
                        </div>

                        <div class="rounded-2xl border border-slate-800 bg-slate-950/70 px-4 py-3">
                            <div class="text-slate-500">Current Level</div>
                            <div class="mt-1 font-medium text-white">Level {{ $currentLevel }}</div>
                        </div>

                        <div class="rounded-2xl border border-slate-800 bg-slate-950/70 px-4 py-3">
                            <div class="text-slate-500">Achievements</div>
                            <div class="mt-1 font-medium text-white">{{ $playerAchievements->count() }}</div>
                        </div>

                        <div class="rounded-2xl border border-slate-800 bg-slate-950/70 px-4 py-3">
                            <div class="text-slate-500">Assigned Cases</div>
                            <div class="mt-1 font-medium text-white">{{ $player->cases->count() }}</div>
                        </div>

                        <div class="rounded-2xl border border-slate-800 bg-slate-950/70 px-4 py-3">
                            <div class="text-slate-500">Last Login</div>
                            <div class="mt-1 font-medium text-white">{{ optional($player->last_login)->format('Y-m-d H:i') ?? 'Never' }}</div>
                        </div>

                        <div class="rounded-2xl border border-slate-800 bg-slate-950/70 px-4 py-3">
                            <div class="text-slate-500">Account Created Date</div>
                            <div class="mt-1 font-medium text-white">{{ optional($player->created_at)->format('Y-m-d H:i') ?? '—' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection