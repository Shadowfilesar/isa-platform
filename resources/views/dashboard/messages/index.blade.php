@extends('layouts.app')

@section('title', 'Director Messages')

@section('breadcrumb')
<span class="text-amber-400">Messages</span>
@endsection

@section('content')
<div class="min-h-screen flex">
    @include('dashboard.partials.sidebar')

    <div class="flex-1">
        @include('dashboard.partials.header')
        @include('dashboard.partials.breadcrumb')
        @include('dashboard.partials.alerts')

        <main class="p-8">
            <div class="executive-card overflow-hidden">
                <div class="border-b border-slate-800 px-8 py-6">
                    <h1 class="text-3xl font-bold text-white">Messages</h1>
                    <p class="mt-2 text-slate-400">All Director Messages sent to your account.</p>
                </div>

                @if($messages->isEmpty())
                    <div class="px-8 py-16 text-center text-slate-500">
                        No messages found.
                    </div>
                @else
                    <div class="divide-y divide-slate-800">
                        @foreach($messages as $message)
                            <a href="{{ route('messages.show', $message) }}"
                               class="block px-8 py-5 hover:bg-slate-900/40 {{ $message->is_read ? '' : 'bg-slate-900/60' }}">
                                <div class="flex items-center justify-between gap-6">
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-3">
                                            <h2 class="truncate text-lg font-semibold text-white">
                                                {{ $message->subject }}
                                            </h2>

                                            @if($message->is_read)
                                                <span class="rounded-full bg-slate-800 px-3 py-1 text-xs text-slate-300">
                                                    Read
                                                </span>
                                            @else
                                                <span class="rounded-full bg-amber-900 px-3 py-1 text-xs text-amber-300">
                                                    Unread
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="shrink-0 text-sm text-slate-400">
                                        {{ $message->created_at?->format('Y-m-d H:i') }}
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>
@endsection