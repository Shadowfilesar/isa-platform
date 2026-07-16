<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('player_cases', function (Blueprint $table) {

            $table->id();

            $table->foreignId('player_id')->constrained('players')->cascadeOnDelete();

            $table->foreignId('case_id')->constrained('cases')->cascadeOnDelete();

            $table->timestamp('activated_at')->useCurrent();

            $table->boolean('completed')->default(false);

            $table->integer('score')->default(0);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('player_cases');
    }
};