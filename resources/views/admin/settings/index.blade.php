@extends('layouts.admin')

@section('title','Settings')

@section('content')
<div class="min-h-screen bg-slate-950 text-slate-100">
    <div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full border border-cyan-500/20 bg-cyan-500/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-cyan-300">
                    <span class="inline-block h-2 w-2 rounded-full bg-cyan-400"></span>
                    Admin Configuration
                </div>
                <h1 class="mt-3 text-2xl font-semibold tracking-tight text-white sm:text-3xl">Settings</h1>
                <p class="mt-2 max-w-3xl text-sm text-slate-400 sm:text-base">
                    Configure the ISA platform, tune system behavior, and review operational preferences from a single control panel.
                </p>
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

        @if(isset($errors) && $errors->any())
            <div class="mb-6 rounded-2xl border border-rose-500/20 bg-rose-500/10 px-5 py-4 text-sm text-rose-300">
                <ul class="space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid gap-6 xl:grid-cols-3">
            <div class="xl:col-span-2">
                <form method="POST" action="{{ route('admin.settings.update') }}" class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900/80 shadow-2xl shadow-black/20">
                    @csrf
                    @method('PUT')

                    <div class="border-b border-slate-800 px-6 py-5">
                        <h2 class="text-lg font-semibold text-white">Platform Settings</h2>
                        <p class="mt-1 text-sm text-slate-400">
                            Update the active configuration values used by the admin panel.
                        </p>
                    </div>

                    <div class="grid gap-6 p-6 md:grid-cols-2">
                        <div>
                            <label for="platform_name" class="mb-2 block text-sm font-medium text-slate-200">Platform Name</label>
                            <input id="platform_name"
                                   name="platform_name"
                                   type="text"
                                   value="{{ old('platform_name', $settings['platform_name'] ?? config('app.name')) }}"
                                   class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                            @error('platform_name')
                                <div class="mt-2 text-sm text-rose-300">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="platform_tagline" class="mb-2 block text-sm font-medium text-slate-200">Platform Tagline</label>
                            <input id="platform_tagline"
                                   name="platform_tagline"
                                   type="text"
                                   value="{{ old('platform_tagline', $settings['platform_tagline'] ?? '') }}"
                                   class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                            @error('platform_tagline')
                                <div class="mt-2 text-sm text-rose-300">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="contact_email" class="mb-2 block text-sm font-medium text-slate-200">Contact Email</label>
                            <input id="contact_email"
                                   name="contact_email"
                                   type="email"
                                   value="{{ old('contact_email', $settings['contact_email'] ?? '') }}"
                                   class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                            @error('contact_email')
                                <div class="mt-2 text-sm text-rose-300">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="support_email" class="mb-2 block text-sm font-medium text-slate-200">Support Email</label>
                            <input id="support_email"
                                   name="support_email"
                                   type="email"
                                   value="{{ old('support_email', $settings['support_email'] ?? '') }}"
                                   class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                            @error('support_email')
                                <div class="mt-2 text-sm text-rose-300">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="registration_enabled" class="mb-2 block text-sm font-medium text-slate-200">Registration Status</label>
                            <select id="registration_enabled"
                                    name="registration_enabled"
                                    class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                                <option value="1" @selected(old('registration_enabled', (string) ($settings['registration_enabled'] ?? '1')) === '1')>Enabled</option>
                                <option value="0" @selected(old('registration_enabled', (string) ($settings['registration_enabled'] ?? '1')) === '0')>Disabled</option>
                            </select>
                            @error('registration_enabled')
                                <div class="mt-2 text-sm text-rose-300">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="missions_enabled" class="mb-2 block text-sm font-medium text-slate-200">Missions Status</label>
                            <select id="missions_enabled"
                                    name="missions_enabled"
                                    class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                                <option value="1" @selected(old('missions_enabled', (string) ($settings['missions_enabled'] ?? '1')) === '1')>Enabled</option>
                                <option value="0" @selected(old('missions_enabled', (string) ($settings['missions_enabled'] ?? '1')) === '0')>Disabled</option>
                            </select>
                            @error('missions_enabled')
                                <div class="mt-2 text-sm text-rose-300">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="maintenance_message" class="mb-2 block text-sm font-medium text-slate-200">Maintenance Message</label>
                            <textarea id="maintenance_message"
                                      name="maintenance_message"
                                      rows="5"
                                      class="w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">{{ old('maintenance_message', $settings['maintenance_message'] ?? '') }}</textarea>
                            @error('maintenance_message')
                                <div class="mt-2 text-sm text-rose-300">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="border-t border-slate-800 px-6 py-5">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <p class="text-sm text-slate-400">
                                Changes take effect after saving and may influence the public and admin experience.
                            </p>
                            <button type="submit"
                                    class="inline-flex items-center justify-center rounded-xl bg-cyan-500 px-4 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-400">
                                Save Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="space-y-6">
                <div class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900/80 shadow-2xl shadow-black/20">
                    <div class="border-b border-slate-800 px-6 py-5">
                        <h2 class="text-lg font-semibold text-white">System Status</h2>
                        <p class="mt-1 text-sm text-slate-400">
                            Current configuration overview and control state.
                        </p>
                    </div>

                    <div class="space-y-3 p-6 text-sm">
                        <div class="rounded-2xl border border-cyan-500/20 bg-cyan-500/10 px-4 py-3 text-cyan-300">
                            Admin settings are editable by authorized administrators only.
                        </div>
                        <div class="rounded-2xl border border-slate-800 bg-slate-950/70 px-4 py-3 text-slate-300">
                            Public registration: <span class="font-semibold text-white">{{ ($settings['registration_enabled'] ?? true) ? 'Enabled' : 'Disabled' }}</span>
                        </div>
                        <div class="rounded-2xl border border-slate-800 bg-slate-950/70 px-4 py-3 text-slate-300">
                            Missions: <span class="font-semibold text-white">{{ ($settings['missions_enabled'] ?? true) ? 'Enabled' : 'Disabled' }}</span>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900/80 shadow-2xl shadow-black/20">
                    <div class="border-b border-slate-800 px-6 py-5">
                        <h2 class="text-lg font-semibold text-white">Quick Notes</h2>
                        <p class="mt-1 text-sm text-slate-400">
                            Keep important configuration values visible for the admin team.
                        </p>
                    </div>

                    <div class="space-y-3 p-6 text-sm text-slate-300">
                        <div class="rounded-2xl border border-slate-800 bg-slate-950/70 px-4 py-3">
                            Validate all required values before saving.
                        </div>
                        <div class="rounded-2xl border border-slate-800 bg-slate-950/70 px-4 py-3">
                            Use this page for small system toggles and platform labels.
                        </div>
                        <div class="rounded-2xl border border-slate-800 bg-slate-950/70 px-4 py-3">
                            Keep the maintenance message concise and actionable.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection