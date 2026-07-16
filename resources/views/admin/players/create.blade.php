@extends('layouts.admin')

@section('title', 'Create Player')

@section('content')
<div class="min-h-screen bg-slate-950 text-slate-100">
    <div class="mx-auto w-full max-w-4xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full border border-cyan-500/20 bg-cyan-500/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-cyan-300">
                    <span class="inline-block h-2 w-2 rounded-full bg-cyan-400"></span>
                    Player Management
                </div>
                <h1 class="mt-3 text-2xl font-semibold tracking-tight text-white sm:text-3xl">Create Player</h1>
                <p class="mt-2 max-w-2xl text-sm text-slate-400 sm:text-base">
                    Register a new operative account and define mission access, rank, and clearance.
                </p>
            </div>

            <a href="{{ route('admin.players.index') }}"
               class="inline-flex items-center justify-center rounded-xl border border-slate-800 bg-slate-900/80 px-4 py-2.5 text-sm font-medium text-slate-200 shadow-lg shadow-black/20 transition hover:border-slate-700 hover:bg-slate-800">
                Back to Players
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-rose-500/20 bg-rose-500/10 px-5 py-4 text-sm text-rose-300">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.players.store') }}" class="space-y-6">
            @csrf

            <div class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900/80 shadow-2xl shadow-black/20">
                <div class="border-b border-slate-800 px-6 py-5">
                    <h2 class="text-lg font-semibold text-white">Account Profile</h2>
                    <p class="mt-1 text-sm text-slate-400">
                        Enter the operative identity details used by the authentication and assignment systems.
                    </p>
                </div>

                <div class="grid gap-6 p-6 md:grid-cols-2">
                    <div>
                        <label for="username" class="mb-2 block text-sm font-medium text-slate-200">Username</label>
                        <input id="username"
                               name="username"
                               type="text"
                               value="{{ old('username') }}"
                               placeholder="operative.shadow"
                               class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                        @error('username')
                            <div class="mt-2 text-sm text-rose-300">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="account_code" class="mb-2 block text-sm font-medium text-slate-200">Account Code</label>
                        <input id="account_code"
                               name="account_code"
                               type="text"
                               value="{{ old('account_code') }}"
                               placeholder="ISA-0001"
                               class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                        @error('account_code')
                            <div class="mt-2 text-sm text-rose-300">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="password" class="mb-2 block text-sm font-medium text-slate-200">Password</label>
                        <input id="password"
                               name="password"
                               type="password"
                               placeholder="Create a secure password"
                               class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                        @error('password')
                            <div class="mt-2 text-sm text-rose-300">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="grid gap-6 xl:grid-cols-3">
                <div class="xl:col-span-2">
                    <div class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900/80 shadow-2xl shadow-black/20">
                        <div class="border-b border-slate-800 px-6 py-5">
                            <h2 class="text-lg font-semibold text-white">Access Controls</h2>
                            <p class="mt-1 text-sm text-slate-400">
                                Define the player rank, clearance, and operational account status.
                            </p>
                        </div>

                        <div class="grid gap-6 p-6 md:grid-cols-2">
                            <div>
                                <label for="rank" class="mb-2 block text-sm font-medium text-slate-200">Rank</label>
                                <input id="rank"
                                       name="rank"
                                       type="text"
                                       value="{{ old('rank') }}"
                                       placeholder="Detective"
                                       class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                                @error('rank')
                                    <div class="mt-2 text-sm text-rose-300">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="clearance_level" class="mb-2 block text-sm font-medium text-slate-200">Clearance Level</label>
                                <input id="clearance_level"
                                       name="clearance_level"
                                       type="text"
                                       value="{{ old('clearance_level') }}"
                                       placeholder="Level 1"
                                       class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                                @error('clearance_level')
                                    <div class="mt-2 text-sm text-rose-300">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <input type="hidden" name="status" value="inactive">

                                <label class="flex items-start gap-4 rounded-2xl border border-slate-800 bg-slate-950/70 p-4 transition hover:border-slate-700">
                                    <input type="checkbox"
                                           name="status"
                                           value="active"
                                           @checked(old('status', 'active') === 'active')
                                           class="mt-1 h-4 w-4 rounded border-slate-600 bg-slate-900 text-cyan-500 focus:ring-cyan-500/30">
                                    <div>
                                        <div class="text-sm font-semibold text-white">Active Account</div>
                                        <div class="mt-1 text-sm text-slate-400">
                                            When enabled, the player is created with <span class="font-medium text-cyan-300">status=active</span>. If unchecked, the form submits <span class="font-medium text-slate-300">status=inactive</span>.
                                        </div>
                                    </div>
                                </label>

                                @error('status')
                                    <div class="mt-2 text-sm text-rose-300">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="overflow-hidden rounded-3xl border border-slate-800 bg-gradient-to-br from-cyan-500/10 via-slate-900 to-slate-900 shadow-2xl shadow-black/20">
                        <div class="px-6 py-5">
                            <h2 class="text-lg font-semibold text-white">Submission</h2>
                            <p class="mt-1 text-sm text-slate-300">
                                Save the player profile and activate it immediately if required.
                            </p>
                        </div>

                        <div class="space-y-3 px-6 pb-6">
                            <button type="submit"
                                    class="inline-flex w-full items-center justify-center rounded-xl bg-cyan-500 px-4 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-400">
                                Create Player
                            </button>

                            <a href="{{ route('admin.players.index') }}"
                               class="inline-flex w-full items-center justify-center rounded-xl border border-slate-700 bg-slate-950/70 px-4 py-3 text-sm font-medium text-slate-200 transition hover:border-slate-600 hover:bg-slate-900">
                                Cancel
                            </a>
                        </div>
                    </div>

                    <div class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900/80 shadow-2xl shadow-black/20">
                        <div class="border-b border-slate-800 px-6 py-5">
                            <h2 class="text-lg font-semibold text-white">Field Mapping</h2>
                            <p class="mt-1 text-sm text-slate-400">
                                This form is aligned with the current player controller requirements.
                            </p>
                        </div>

                        <div class="space-y-3 p-6 text-sm text-slate-300">
                            <div class="rounded-2xl border border-slate-800 bg-slate-950/70 px-4 py-3">username</div>
                            <div class="rounded-2xl border border-slate-800 bg-slate-950/70 px-4 py-3">account_code</div>
                            <div class="rounded-2xl border border-slate-800 bg-slate-950/70 px-4 py-3">password</div>
                            <div class="rounded-2xl border border-slate-800 bg-slate-950/70 px-4 py-3">rank</div>
                            <div class="rounded-2xl border border-slate-800 bg-slate-950/70 px-4 py-3">clearance_level</div>
                            <div class="rounded-2xl border border-slate-800 bg-slate-950/70 px-4 py-3">status</div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection