{{-- resources/views/dashboard/notifications/index.blade.php --}}
@extends('layouts.app')


@section('title','Notifications')


@section('page-title','Notifications')


@section('page-description','Agency Notifications')


@section('breadcrumb','Notifications')


@section('back-button', route('dashboard'))


@section('content')

@include('dashboard.partials.alerts')

<main class="p-8 space-y-8">


    <div class="executive-card p-8">


        <div class="flex items-center justify-between">


            <div>


                <h1 class="text-3xl font-bold text-white">


                    Notifications


                </h1>


                <p class="mt-2 text-slate-500">


                    Latest updates from the Intelligence Security Agency.


                </p>


            </div>


            <form
                method="POST"
                action="{{ route('notifications.read-all') }}">


                @csrf


                <button
                    type="submit"
                    class="rounded-lg bg-blue-600 px-6 py-3 font-semibold text-white transition hover:bg-blue-500">


                    Mark All as Read


                </button>


            </form>


        </div>


    </div>


    <div class="space-y-5">
                        @forelse($notifications as $notification)


            <div
                class="executive-card p-6 transition hover:border-amber-500">


                <div class="flex items-start justify-between gap-6">


                    <div class="flex-1">


                        <div class="flex items-center gap-3">


                            @if($notification->is_read)


                                <span
                                    class="rounded-full bg-green-900 px-3 py-1 text-xs font-semibold text-green-300">


                                    Read


                                </span>


                            @else


                                <span
                                    class="rounded-full bg-amber-900 px-3 py-1 text-xs font-semibold text-amber-300">


                                    New


                                </span>


                            @endif


                            <span class="text-sm text-slate-500">


                                {{ $notification->created_at->diffForHumans() }}


                            </span>


                        </div>


                        <h2 class="mt-5 text-2xl font-semibold text-white">


                            {{ $notification->title }}


                        </h2>


                        <p class="mt-3 leading-7 text-slate-400">


                            {{ $notification->message }}


                        </p>


                    </div>


                    <div>


                        @if(! $notification->is_read)


                            <form
                                method="POST"
                                action="{{ route('notifications.read',$notification) }}">


                                @csrf


                                <button
                                    type="submit"
                                    class="rounded-lg bg-green-600 px-5 py-3 font-semibold text-white transition hover:bg-green-500">


                                    Mark as Read


                                </button>


                            </form>


                        @else


                            <div
                                class="rounded-lg bg-slate-800 px-5 py-3 text-center text-green-400">


                                ✓ Read


                            </div>


                        @endif


                    </div>


                </div>


            </div>


        @empty


            <div
                class="executive-card p-12 text-center">


                <div class="text-6xl">


                    🔔


                </div>


                <h2
                    class="mt-6 text-2xl font-semibold text-white">


                    No Notifications


                </h2>


                <p
                    class="mt-3 text-slate-500">


                    You don't have any notifications yet.


                </p>


            </div>


        @endforelse
                    </div>


    @if($notifications->hasPages())


        <div class="flex justify-center">


            {{ $notifications->links() }}


        </div>


    @endif


</main>

@endsection