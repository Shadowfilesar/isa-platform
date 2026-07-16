<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();

            $table->string('account_code')->unique();

            $table->string('password');

            $table->integer('level')->default(1);

            $table->integer('xp')->default(0);

            $table->string('rank')->default('Recruit');

            $table->timestamp('last_login')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};