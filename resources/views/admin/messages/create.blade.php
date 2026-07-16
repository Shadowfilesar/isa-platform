@extends('layouts.admin')

@section('title','Director Messages')

@section('content')

<div class="p-10">

    <div class="flex items-center justify-between mb-8">

        <div>

            <h1 class="text-4xl font-bold text-white">

                Director Messages

            </h1>

            <p class="mt-2 text-slate-500">

                Send secure messages to ISA agents.

            </p>

        </div>

        <a
            href="{{ route('admin.dashboard') }}"
            class="rounded bg-slate-800 px-6 py-3 text-white">

            ← Dashboard

        </a>

    </div>

    @if(session('success'))

        <div class="mb-6 rounded-lg bg-green-600 px-6 py-4 text-white">

            {{ session('success') }}

        </div>

    @endif

    @if($errors->any())

        <div class="mb-6 rounded-lg bg-red-600 px-6 py-4 text-white">

            <ul class="space-y-2">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <form
        action="{{ route('admin.messages.store') }}"
        method="POST"
        class="executive-card p-8">

        @csrf
                <div class="grid grid-cols-1 gap-6">

            <div>

                <label class="mb-2 block text-sm font-medium text-slate-300">

                    Select Agent

                </label>

                <select
                    name="player_id"
                    class="w-full rounded-lg border border-slate-700 bg-slate-900 px-4 py-3 text-white">

                    @foreach($players as $player)

                        <option
                            value="{{ $player->id }}"
                            @selected(old('player_id') == $player->id)>

                            {{ $player->account_code }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div>

                <label class="mb-2 block text-sm font-medium text-slate-300">

                    Subject

                </label>

                <input
                    type="text"
                    name="subject"
                    value="{{ old('subject') }}"
                    class="w-full rounded-lg border border-slate-700 bg-slate-900 px-4 py-3 text-white"
                    placeholder="Message subject">

            </div>

            <div>

                <label class="mb-2 block text-sm font-medium text-slate-300">

                    Message

                </label>

                <textarea
                    name="message"
                    rows="12"
                    class="w-full rounded-lg border border-slate-700 bg-slate-900 px-4 py-3 text-white"
                    placeholder="Write your message here...">{{ old('message') }}</textarea>

            </div>

        </div>

        <div class="mt-8 flex justify-end gap-4">
                        <a
                href="{{ route('admin.dashboard') }}"
                class="rounded-lg bg-slate-700 px-6 py-3 font-semibold text-white transition hover:bg-slate-600">

                Cancel

            </a>

            <button
                type="submit"
                class="rounded-lg bg-blue-700 px-6 py-3 font-semibold text-white transition hover:bg-blue-600">

                Send Message

            </button>

        </div>

    </form>

</div>

@endsection