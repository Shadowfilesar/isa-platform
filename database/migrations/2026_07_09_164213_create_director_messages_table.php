@extends('layouts.app')

@section('title', $message->subject)

@section('breadcrumb')
<a href="{{ route('messages.index') }}" class="text-slate-400 hover:text-white">Messages</a>
<span class="text-slate-600">/</span>
<span class="text-amber-400">{{ $message->subject }}</span>
@endsection

@section('content')
<div class="min-h-screen flex">
    @include('dashboard.partials.sidebar')

    <div class="flex-1">
        @include('dashboard.partials.header')
        @include('dashboard.partials.breadcrumb')
        @include('dashboard.partials.alerts')

        <main class="p-8 space-y-8">
            <div class="executive-card p-8">
                <div class="mb-6 flex items-start justify-between gap-4">
                    <div>
                        <div class="text-sm uppercase tracking-[0.3em] text-amber-500">
                            Director Communication
                        </div>

                        <h1 class="mt-3 text-4xl font-bold text-white">
                            {{ $message->subject }}
                        </h1>
                    </div>

                    <a
                        href="{{ route('messages.index') }}"
                        class="rounded-lg border border-slate-700 bg-slate-900 px-5 py-3 text-white hover:border-amber-500">
                        Back to Inbox
                    </a>
                </div>

                <div class="mb-6 text-sm text-slate-500">
                    Received {{ $message->created_at?->format('Y-m-d H:i') }}
                </div>

                <div class="rounded-xl border border-slate-800 bg-slate-900/60 p-6">
                    <div class="whitespace-pre-line text-base leading-8 text-slate-200">
                        {{ $message->message }}
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection