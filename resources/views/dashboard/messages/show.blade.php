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

        <main class="p-8">
            <div class="executive-card p-8">
                <div class="mb-8 flex items-start justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-white">
                            {{ $message->subject }}
                        </h1>

                        <p class="mt-2 text-sm text-slate-400">
                            Received {{ $message->created_at?->format('Y-m-d H:i') }}
                        </p>
                    </div>

                    <a href="{{ route('messages.index') }}"
                       class="rounded-lg bg-slate-800 px-5 py-3 text-white hover:bg-slate-700">
                        Back
                    </a>
                </div>

                <div class="rounded-lg border border-slate-800 bg-slate-900/50 p-6">
                    <div class="whitespace-pre-line leading-8 text-slate-200">
                        {{ $message->message }}
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection