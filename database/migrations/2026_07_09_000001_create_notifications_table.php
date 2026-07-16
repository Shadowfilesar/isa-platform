<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {

            $table->id();

            $table->foreignId('player_id')
                ->constrained('players')
                ->cascadeOnDelete();

            $table->string('type', 50);

            $table->string('title');

            $table->text('message');

            $table->string('icon')
                ->default('bell');

            $table->string('color')
                ->default('blue');

            $table->string('link')
                ->nullable();

            $table->boolean('is_read')
                ->default(false);

            $table->timestamps();

            $table->index([
                'player_id',
                'is_read',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};