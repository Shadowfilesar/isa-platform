@extends('layouts.admin')

@section('title','Players')

@section('content')

<div class="p-10">

    <div class="mb-8 flex items-center justify-between">

        <div>

            <a
                href="{{ route('admin.dashboard') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-slate-700 bg-slate-900 px-5 py-3 text-white hover:border-amber-500">

                ← Dashboard

            </a>

            <div class="mt-5 text-sm text-slate-500">

                <a href="{{ route('admin.dashboard') }}" class="hover:text-white">

                    Dashboard

                </a>

                <span class="mx-2">/</span>

                <span class="text-amber-400">

                    Players

                </span>

            </div>

            <h1 class="mt-6 text-4xl font-bold text-white">

                Player Management

            </h1>

            <p class="mt-2 text-slate-500">

                Manage all ISA investigators.

            </p>

        </div>

        <a
            href="{{ route('admin.players.create') }}"
            class="rounded-lg bg-amber-600 px-6 py-3 font-semibold text-white hover:bg-amber-500">

            + Create Player

        </a>

    </div>

    <div class="executive-card overflow-hidden">

        <table class="w-full">

            <thead class="bg-slate-900">

                <tr>

                    <th class="p-4 text-left">

                        Account

                    </th>

                    <th class="p-4 text-left">

                        Rank

                    </th>

                    <th class="p-4 text-left">

                        Level

                    </th>

                    <th class="p-4 text-left">

                        XP

                    </th>

                    <th class="p-4 text-left">

                        Status

                    </th>

                    <th class="p-4 text-right">

                        Actions

                    </th>

                </tr>

            </thead>

            <tbody>

            @forelse($players as $player)
                            <tr class="border-t border-slate-800 hover:bg-slate-900/40">

                    <td class="p-4">

                        <div class="font-semibold text-white">

                            {{ $player->account_code }}

                        </div>

                        <div class="mt-1 text-sm text-slate-500">

                           {{ optional($player->created_at)->format('Y-m-d') ?? '-' }}

                        </div>

                    </td>

                    <td class="p-4">

                        <span class="rounded-full bg-amber-900 px-3 py-1 text-sm text-amber-300">

                            {{ $player->rank }}

                        </span>

                    </td>

                    <td class="p-4 font-semibold text-white">

                        {{ $player->level }}

                    </td>

                    <td class="p-4 font-semibold text-green-400">

                        {{ number_format($player->xp) }}

                    </td>

                    <td class="p-4">

                        @if($player->is_active)

                            <span class="rounded-full bg-green-900 px-3 py-1 text-sm text-green-300">

                                Active

                            </span>

                        @else

                            <span class="rounded-full bg-red-900 px-3 py-1 text-sm text-red-300">

                                Suspended

                            </span>

                        @endif

                    </td>

                    <td class="p-4">

                        <div class="flex justify-end gap-3">

                            <a
                                href="{{ route('admin.players.edit',$player) }}"
                                class="rounded-lg bg-amber-600 px-4 py-2 text-white hover:bg-amber-500">

                                Edit

                            </a>

                            <a
                                href="{{ route('admin.players.assign-cases',$player) }}"
                                class="rounded-lg bg-blue-700 px-4 py-2 text-white hover:bg-blue-600">

                                Cases

                            </a>

                            <form
                                action="{{ route('admin.players.destroy',$player) }}"
                                method="POST"
                                onsubmit="return confirm('Delete this player?')">

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
                        colspan="6"
                        class="py-16 text-center text-slate-500">

                        No players found.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-8">

        {{ $players->links() }}

    </div>

</div>

@endsection