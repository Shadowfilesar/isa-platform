<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('director_messages', function (Blueprint $table) {

            $table->id();

            $table->foreignId('player_id')
                ->constrained('players')
                ->cascadeOnDelete();

            $table->string('subject');

            $table->longText('message');

            $table->timestamp('read_at')
                ->nullable();

            $table->timestamps();

            $table->index([
                'player_id',
                'created_at',
            ]);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'director_messages'
        );
    }
};