@extends('layouts.app')

@section('title', 'Activate Account')

@section('content')

<div class="relative min-h-screen flex items-center justify-center px-4">

    <div class="absolute top-1/4 left-1/4 w-[500px] h-[500px] bg-isa-gold/5 rounded-full blur-[120px]"></div>

    <div class="absolute bottom-1/4 right-1/4 w-[500px] h-[500px] bg-slate-800/20 rounded-full blur-[120px]"></div>

    <div class="relative w-full max-w-xl executive-card executive-glow p-10 overflow-hidden">

        <div class="absolute top-0 right-0 w-3 h-3 border-t border-r border-isa-gold/40"></div>

        <div class="absolute bottom-0 left-0 w-3 h-3 border-b border-l border-isa-gold/40"></div>

        <div class="text-center">

            <div class="flex justify-center mb-6">

                <div class="w-16 h-16 text-isa-gold">

                    <svg viewBox="0 0 100 100"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.5">

                        <circle
                            cx="50"
                            cy="50"
                            r="45"
                            stroke-dasharray="1 3"/>

                        <circle
                            cx="50"
                            cy="50"
                            r="38"/>

                        <polygon
                            points="50,28 62,50 50,72 38,50"/>

                        <circle
                            cx="50"
                            cy="50"
                            r="5"
                            fill="currentColor"/>

                    </svg>

                </div>

            </div>

            <h1 class="text-2xl text-white tracking-[6px] font-bold uppercase">

                First Account Activation

            </h1>

            <p class="text-[11px] text-isa-gold mt-2 tracking-[4px] uppercase">

                Investigator Password Creation

            </p>

        </div>

        <div class="border-b border-slate-800 my-8"></div>

        <div class="bg-black/20 border-r-2 border-isa-gold/30 p-4 text-xs leading-7 text-slate-400">

            تم التحقق من كود المحقق بنجاح.

            هذه هي أول عملية دخول للحساب.

            يجب إنشاء كلمة مرور آمنة قبل السماح بالوصول إلى منصة ISA.

        </div>

        <div class="mt-6">

            <div class="flex justify-between text-xs">

                <span class="text-slate-500">

                    Account Code

                </span>

                <span class="text-isa-gold font-mono">

                    {{ $player->account_code }}

                </span>

            </div>

        </div>

        <form
            action="{{ route('activation.store',$player->account_code) }}"
            method="POST"
            class="mt-8 space-y-6">

            @csrf

            <div>

                <label class="block text-xs text-slate-400 mb-2 font-mono">

                    New Password

                </label>

                <input
                    type="password"
                    name="password"
                    class="isa-input"
                    required
                    autocomplete="new-password">

            </div>

            <div>

                <label class="block text-xs text-slate-400 mb-2 font-mono">

                    Confirm Password

                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    class="isa-input"
                    required
                    autocomplete="new-password">

            </div>
                        <div class="pt-2">

                <button
                    type="submit"
                    class="isa-button">

                    <i class="fa-solid fa-lock mr-2"></i>

                    ACTIVATE ACCOUNT

                </button>

            </div>

        </form>

        <div class="mt-10 pt-5 border-t border-slate-800 flex justify-between items-center">

            <div>

                <p class="text-[10px] text-slate-500 font-mono">

                    SECURITY STATUS

                </p>

                <p class="text-[10px] text-isa-gold font-mono">

                    FIRST ACTIVATION

                </p>

            </div>

            <div class="text-right">

                <p class="text-[10px] text-slate-500 font-mono">

                    ACCOUNT

                </p>

                <p class="text-[10px] text-isa-gold font-mono">

                    {{ $player->account_code }}

                </p>

            </div>

        </div>

    </div>

</div>

@endsection