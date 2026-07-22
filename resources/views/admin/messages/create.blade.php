@extends('layouts.admin')

@section('title', 'Send Director Message')

@section('breadcrumb')
<span class="text-slate-400">Director Messages</span>
<span class="text-slate-600">/</span>
<span class="text-amber-400">Compose</span>
@endsection

@section('admin-content')
<div class="max-w-4xl">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-white">Send Director Message</h1>
        <p class="mt-2 text-slate-500">Send a secure message directly to an investigator inbox.</p>
    </div>

    <div class="executive-card p-8">
        <form method="POST" action="{{ route('admin.messages.store') }}" class="space-y-6">
            @csrf

            <div>
                <label for="player_id" class="mb-2 block text-sm font-semibold text-slate-300">Recipient</label>
                <select id="player_id" name="player_id" class="isa-input" required>
                    <option value="">Select player</option>
                    @foreach($players as $recipient)
                        <option value="{{ $recipient->id }}" @selected(old('player_id') == $recipient->id)>
                            {{ $recipient->account_code }} - {{ $recipient->rank }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="subject" class="mb-2 block text-sm font-semibold text-slate-300">Subject</label>
                <input
                    id="subject"
                    name="subject"
                    type="text"
                    value="{{ old('subject') }}"
                    class="isa-input"
                    required>
            </div>

            <div>
                <label for="message" class="mb-2 block text-sm font-semibold text-slate-300">Message</label>
                <textarea
                    id="message"
                    name="message"
                    rows="10"
                    class="isa-input"
                    required>{{ old('message') }}</textarea>
            </div>

            <div class="flex justify-end">
                <button
                    type="submit"
                    class="rounded-lg bg-amber-600 px-8 py-3 font-semibold text-white hover:bg-amber-500">
                    Send Message
                </button>
            </div>
        </form>
    </div>
</div>
@endsection