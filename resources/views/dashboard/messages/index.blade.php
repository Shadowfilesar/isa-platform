{{-- resources/views/dashboard/messages/index.blade.php --}}
@extends('layouts.app')


@section('title','Director Inbox')


@section('page-title','Director Inbox')


@section('page-description','Secure communications from Operations Director')


@section('breadcrumb','Director Inbox')


@section('back-button', route('dashboard'))


@section('content')

@include('dashboard.partials.alerts')

<main class="p-8 space-y-8">


    <div class="executive-card p-8">


        <div class="flex items-center justify-between">


            <div>


                <h1 class="text-3xl font-bold text-white">


                    Director Inbox


                </h1>


                <p class="mt-2 text-slate-500">


                    Secure messages sent by the Operations Director.


                </p>


            </div>


            <div class="rounded-lg bg-slate-900 px-5 py-3">


                <div class="text-sm text-slate-500">


                    Total Messages


                </div>


                <div class="mt-1 text-2xl font-bold text-white">


                    {{ $messages->total() }}


                </div>


            </div>


        </div>


    </div>


    <div class="space-y-5">
                        @forelse($messages as $message)


            <a
                href="{{ route('messages.show',$message) }}"
                class="block rounded-xl border border-slate-800 bg-slate-900 p-6 transition hover:border-amber-500 hover:bg-slate-800">


                <div class="flex items-start justify-between gap-6">


                    <div class="flex-1">


                        <div class="flex items-center gap-3">


                            @if($message->isRead())


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


                                {{ $message->created_at->diffForHumans() }}


                            </span>


                        </div>


                        <h2 class="mt-5 text-2xl font-semibold text-white">


                            {{ $message->subject }}


                        </h2>


                        <p class="mt-3 leading-7 text-slate-400">


                            {{ \Illuminate\Support\Str::limit($message->message,160) }}


                        </p>


                    </div>


                    <div class="flex items-center">


                        <span
                            class="rounded-lg bg-amber-600 px-5 py-3 font-semibold text-white">


                            Open


                        </span>


                    </div>


                </div>


            </a>


        @empty


            <div class="executive-card p-12 text-center">


                <div class="text-6xl">


                    📬


                </div>


                <h2 class="mt-6 text-2xl font-semibold text-white">


                    Inbox Empty


                </h2>


                <p class="mt-3 text-slate-500">


                    The Operations Director has not sent you any messages yet.


                </p>


            </div>


        @endforelse
                    </div>


    @if($messages->hasPages())


        <div class="flex justify-center">


            {{ $messages->links() }}


        </div>


    @endif


</main>

@endsection