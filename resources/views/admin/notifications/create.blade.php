@extends('layouts.admin')

@section('title','Send Notification')

@section('content')

<div class="space-y-8">

    <div class="flex items-center justify-between">

        <div>

            <div class="mb-4 text-sm text-slate-500">

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="hover:text-white">

                    Dashboard

                </a>

                <span class="mx-2">/</span>

                <a
                    href="{{ route('admin.notifications.index') }}"
                    class="hover:text-white">

                    Notifications

                </a>

                <span class="mx-2">/</span>

                <span class="text-amber-400">

                    Send Notification

                </span>

            </div>

            <h1 class="text-4xl font-bold text-white">

                Send Notification

            </h1>

            <p class="mt-3 text-slate-500">

                Deliver a notification to an investigator.

            </p>

        </div>

        <a
            href="{{ route('admin.notifications.index') }}"
            class="rounded-lg bg-slate-800 px-6 py-3 font-semibold text-white hover:bg-slate-700">

            ← Back

        </a>

    </div>

    <form
        method="POST"
        action="{{ route('admin.notifications.store') }}"
        class="card p-8 space-y-6">

        @csrf

        <div>

            <label class="mb-2 block text-sm text-slate-400">

                Player

            </label>

            <select
                name="player_id"
                class="isa-input">

                @foreach($players as $player)

                    <option value="{{ $player->id }}">

                        {{ $player->account_code }}

                    </option>

                @endforeach

            </select>

        </div>

        <div>

            <label class="mb-2 block text-sm text-slate-400">

                Title

            </label>

            <input
                type="text"
                name="title"
                value="{{ old('title') }}"
                class="isa-input">

        </div>

        <div>

            <label class="mb-2 block text-sm text-slate-400">

                Message

            </label>

            <textarea
                name="message"
                rows="8"
                class="isa-input">{{ old('message') }}</textarea>

        </div>
                <div class="border-t border-slate-800 pt-8">

            <h2 class="mb-6 text-xl font-bold text-white">

                Quick Actions

            </h2>

            <div class="grid gap-4 md:grid-cols-3">

                <a
                    href="{{ route('admin.notifications.index') }}"
                    class="rounded-lg bg-slate-800 px-6 py-4 text-center font-semibold text-white hover:bg-slate-700">

                    🔔 All Notifications

                </a>

                <a
                    href="{{ route('admin.players.index') }}"
                    class="rounded-lg bg-slate-800 px-6 py-4 text-center font-semibold text-white hover:bg-slate-700">

                    👥 Players

                </a>

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="rounded-lg bg-slate-800 px-6 py-4 text-center font-semibold text-white hover:bg-slate-700">

                    🏠 Dashboard

                </a>

            </div>

        </div>

        <div class="mt-10 flex items-center justify-end gap-4 border-t border-slate-800 pt-8">

            <a
                href="{{ route('admin.notifications.index') }}"
                class="rounded-lg border border-slate-700 bg-slate-900 px-8 py-3 font-semibold text-white hover:border-slate-500">

                Cancel

            </a>

            <button
                type="submit"
                class="rounded-lg bg-amber-600 px-8 py-3 font-semibold text-white hover:bg-amber-500">

                Send Notification

            </button>

        </div>

    </form>

</div>

@endsection