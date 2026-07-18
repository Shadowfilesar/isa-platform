@extends('layouts.admin')

@section('title', 'Admin Login')

@section('content')
<div class="min-h-screen bg-slate-950 text-white flex items-center justify-center p-6">
    <div class="w-full max-w-md rounded-2xl border border-slate-800 bg-slate-900/80 p-8 shadow-2xl">
        <div class="mb-8 text-center">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-amber-600/20 text-amber-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3l7 4v5c0 5-3.5 8.5-7 9-3.5-.5-7-4-7-9V7l7-4z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.5 12.5l1.5 1.5 3.5-4" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold tracking-tight">Director Access</h1>
            <p class="mt-2 text-sm text-slate-400">Restricted administrative login panel for ISA command operations.</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-800 bg-red-950/60 px-4 py-3 text-sm text-red-300">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.store') }}" class="space-y-5">
            @csrf

            <div>
                <label for="username" class="mb-2 block text-sm font-medium text-slate-300">Username</label>
                <input
                    id="username"
                    name="username"
                    type="text"
                    value="{{ old('username') }}"
                    required
                    autofocus
                    class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white placeholder-slate-500 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/30"
                    placeholder="Enter admin username"
                >
            </div>

            <div>
                <label for="password" class="mb-2 block text-sm font-medium text-slate-300">Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white placeholder-slate-500 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/30"
                    placeholder="Enter secure password"
                >
            </div>

            <button
                type="submit"
                class="w-full rounded-xl bg-amber-600 px-4 py-3 font-semibold text-white transition hover:bg-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/40"
            >
                Enter Command Center
            </button>
        </form>
    </div>
</div>
@endsection