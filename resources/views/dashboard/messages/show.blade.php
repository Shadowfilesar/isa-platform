@extends('layouts.app')

@section('title',$message->subject)

@section('page-title','Director Message')

@section('page-description','Secure communication from Operations Director')

@section('breadcrumb','Director Message')

@section('back-button', route('messages.index'))

@section('content')

<div class="min-h-screen flex">

    @include('dashboard.partials.sidebar')

    <div class="flex-1">

        @include('dashboard.partials.header')

        @include('dashboard.partials.breadcrumb')

        @include('dashboard.partials.alerts')

        <main class="p-8 space-y-8">

            <div class="executive-card p-8">

                <div class="flex items-start justify-between gap-6 border-b border-slate-800 pb-6">

                    <div>

                        <div class="flex items-center gap-3">

                            @if($message->isRead())

                                <span class="rounded-full bg-green-900 px-3 py-1 text-xs font-semibold text-green-300">

                                    Read

                                </span>

                            @else

                                <span class="rounded-full bg-amber-900 px-3 py-1 text-xs font-semibold text-amber-300">

                                    New

                                </span>

                            @endif

                        </div>

                        <h1 class="mt-5 text-3xl font-bold text-white">

                            {{ $message->subject }}

                        </h1>

                        <p class="mt-3 text-slate-500">

                            Operations Director

                        </p>

                        <p class="mt-1 text-sm text-slate-500">

                            {{ $message->created_at->format('d M Y - H:i') }}

                        </p>

                    </div>

                    <a
                        href="{{ route('messages.index') }}"
                        class="rounded-lg bg-slate-800 px-5 py-3 text-white transition hover:bg-slate-700">

                        ← Inbox

                    </a>

                </div>
                                <div class="py-8">

                    <div
                        class="rounded-xl border border-slate-800 bg-slate-900 p-8">

                        <div
                            class="whitespace-pre-line leading-8 text-slate-300">

                            {{ $message->message }}

                        </div>

                    </div>

                </div>

            </div>

            <div class="executive-card p-6">

                <div class="flex flex-wrap items-center justify-between gap-4">

                    <div>

                        <h2 class="text-lg font-semibold text-white">

                            Message Information

                        </h2>

                        <p class="mt-2 text-slate-500">

                            This communication was securely delivered through the
                            ISA Director Inbox.

                        </p>

                    </div>

                    <a
                        href="{{ route('messages.index') }}"
                        class="rounded-lg bg-amber-600 px-6 py-3 font-semibold text-white transition hover:bg-amber-500">

                        Return to Inbox

                    </a>

                </div>

            </div>

        </main>

    </div>

</div>

@endsection