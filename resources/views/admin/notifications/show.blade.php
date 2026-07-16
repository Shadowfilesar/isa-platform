@extends('layouts.admin')

@section('title','Notification')

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

                    View Notification

                </span>

            </div>

            <h1 class="text-4xl font-bold text-white">

                Notification Details

            </h1>

        </div>

        <a
            href="{{ route('admin.notifications.index') }}"
            class="rounded-lg bg-slate-800 px-6 py-3 font-semibold text-white hover:bg-slate-700">

            ← Back

        </a>

    </div>

    <div class="card p-8">

        <div class="grid gap-6 md:grid-cols-2">

            <div>

                <label class="block text-sm text-slate-500">

                    Player

                </label>

                <div class="mt-2 text-lg font-semibold text-white">

                    {{ $notification->player->account_code }}

                </div>

            </div>

            <div>

                <label class="block text-sm text-slate-500">

                    Status

                </label>

                <div class="mt-2">

                    @if($notification->is_read)

                        <span class="rounded-full bg-green-900 px-4 py-2 text-green-300">

                            Read

                        </span>

                    @else

                        <span class="rounded-full bg-yellow-900 px-4 py-2 text-yellow-300">

                            Unread

                        </span>

                    @endif

                </div>

            </div>

        </div>

        <div class="mt-8">

            <label class="block text-sm text-slate-500">

                Title

            </label>

            <div class="mt-3 rounded-lg bg-slate-900 p-4 text-xl font-semibold text-white">

                {{ $notification->title }}

            </div>

        </div>

        <div class="mt-8">

            <label class="block text-sm text-slate-500">

                Message

            </label>

            <div class="mt-3 rounded-lg bg-slate-900 p-6 leading-8 text-slate-300">

                {!! nl2br(e($notification->message)) !!}

            </div>

        </div>
                <div class="mt-10 border-t border-slate-800 pt-8">

            <div class="flex flex-wrap justify-end gap-4">

                @if(! $notification->is_read)

                    <form
                        method="POST"
                        action="{{ route('admin.notifications.read',$notification) }}">

                        @csrf

                        @method('PATCH')

                        <button
                            type="submit"
                            class="rounded-lg bg-emerald-700 px-8 py-3 font-semibold text-white hover:bg-emerald-600">

                            Mark as Read

                        </button>

                    </form>

                @endif

                <form
                    method="POST"
                    action="{{ route('admin.notifications.destroy',$notification) }}"
                    onsubmit="return confirm('Delete this notification?')">

                    @csrf

                    @method('DELETE')

                    <button
                        type="submit"
                        class="rounded-lg bg-red-700 px-8 py-3 font-semibold text-white hover:bg-red-600">

                        Delete

                    </button>

                </form>

                <a
                    href="{{ route('admin.notifications.index') }}"
                    class="rounded-lg border border-slate-700 bg-slate-900 px-8 py-3 font-semibold text-white hover:border-slate-500">

                    Back

                </a>

            </div>

        </div>

    </div>

</div>

@endsection