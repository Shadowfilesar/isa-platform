@extends('layouts.admin')

@section('title','Activity Log')

@section('content')

<div class="space-y-8">

    <div>

        <a
            href="{{ route('admin.activity-logs.index') }}"
            class="inline-flex items-center gap-2 rounded-lg border border-slate-700 bg-slate-900 px-5 py-3 text-white hover:border-amber-500">

            ← Back to Activity Logs

        </a>

        <div class="mt-5 text-sm text-slate-500">

            <a
                href="{{ route('admin.dashboard') }}"
                class="hover:text-white">

                Dashboard

            </a>

            <span class="mx-2">/</span>

            <a
                href="{{ route('admin.activity-logs.index') }}"
                class="hover:text-white">

                Activity Logs

            </a>

            <span class="mx-2">/</span>

            <span class="text-amber-400">

                Details

            </span>

        </div>

    </div>

    <div class="card p-8">

        <h1 class="mb-8 text-3xl font-bold text-white">

            Activity Details

        </h1>

        <div class="grid gap-6 md:grid-cols-2">

            <div>

                <label class="mb-2 block text-slate-400">

                    Player

                </label>

                <div class="rounded-lg border border-slate-700 bg-slate-900 px-4 py-3 text-white">

                    {{ $log->player->account_code }}

                </div>

            </div>

            <div>

                <label class="mb-2 block text-slate-400">

                    Action

                </label>

                <div class="rounded-lg border border-slate-700 bg-slate-900 px-4 py-3 text-white">

                    {{ $log->action }}

                </div>

            </div>
                        <div>

                <label class="mb-2 block text-slate-400">

                    Description

                </label>

                <div class="rounded-lg border border-slate-700 bg-slate-900 px-4 py-3 text-white">

                    {{ $log->description }}

                </div>

            </div>

            <div>

                <label class="mb-2 block text-slate-400">

                    Created At

                </label>

                <div class="rounded-lg border border-slate-700 bg-slate-900 px-4 py-3 text-white">

                    {{ $log->created_at?->format('Y-m-d H:i:s') ?? '-' }}

                </div>

            </div>

        </div>

        <div class="mt-10 flex justify-end">

            <form
                method="POST"
                action="{{ route('admin.activity-logs.destroy',$log) }}">

                @csrf

                @method('DELETE')

                <button
                    onclick="return confirm('Delete this activity log?')"
                    class="rounded-lg bg-red-600 px-6 py-3 font-semibold text-white hover:bg-red-500">

                    Delete Log

                </button>

            </form>

        </div>

    </div>

</div>

@endsection