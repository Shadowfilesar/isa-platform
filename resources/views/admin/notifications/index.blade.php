@extends('layouts.admin')

@section('title','Notifications')

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

                <span class="text-amber-400">

                    Notifications

                </span>

            </div>

            <h1 class="text-4xl font-bold text-white">

                Notification Center

            </h1>

            <p class="mt-3 text-slate-500">

                Manage player notifications.

            </p>

        </div>

        <a
            href="{{ route('admin.notifications.create') }}"
            class="rounded-lg bg-amber-600 px-6 py-3 font-semibold text-white hover:bg-amber-500">

            + Send Notification

        </a>

    </div>

    <div class="card overflow-hidden">

        <table class="w-full">

            <thead class="bg-slate-900">

                <tr>

                    <th class="p-4 text-left">

                        Player

                    </th>

                    <th class="p-4 text-left">

                        Title

                    </th>

                    <th class="p-4 text-left">

                        Status

                    </th>

                    <th class="p-4 text-left">

                        Date

                    </th>

                    <th class="p-4 text-right">

                        Actions

                    </th>

                </tr>

            </thead>

            <tbody>

            @forelse($notifications as $notification)
                            <tr class="border-t border-slate-800 hover:bg-slate-900/40">

                    <td class="p-4">

                        <div class="font-semibold text-white">

                            {{ $notification->player->account_code }}

                        </div>

                    </td>

                    <td class="p-4">

                        <div class="font-semibold text-white">

                            {{ $notification->title }}

                        </div>

                        <div class="mt-1 text-sm text-slate-500">

                            {{ \Illuminate\Support\Str::limit($notification->message,80) }}

                        </div>

                    </td>

                    <td class="p-4">

                        @if($notification->read_at)

                            <span class="rounded-full bg-green-900 px-3 py-1 text-sm text-green-300">

                                Read

                            </span>

                        @else

                            <span class="rounded-full bg-yellow-900 px-3 py-1 text-sm text-yellow-300">

                                Unread

                            </span>

                        @endif

                    </td>

                    <td class="p-4 text-slate-400">

                        {{ $notification->created_at->format('Y-m-d H:i') }}

                    </td>

                    <td class="p-4">

                        <div class="flex justify-end gap-3">

                            <a
                                href="{{ route('admin.notifications.show',$notification) }}"
                                class="rounded-lg bg-slate-800 px-4 py-2 text-white hover:bg-slate-700">

                                View

                            </a>

                            <form
                                action="{{ route('admin.notifications.destroy',$notification) }}"
                                method="POST"
                                onsubmit="return confirm('Delete this notification?')">

                                @csrf

                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="rounded-lg bg-red-700 px-4 py-2 text-white hover:bg-red-600">

                                    Delete

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="5"
                        class="py-16 text-center text-slate-500">

                        No notifications found.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-8">

        {{ $notifications->links() }}

    </div>

</div>

@endsection