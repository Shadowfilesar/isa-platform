<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investigation_boards', function (Blueprint $table) {
            $table->id();

            $table->foreignId('player_id')
                ->constrained('players')
                ->cascadeOnDelete();

            $table->foreignId('case_id')
                ->constrained('cases')
                ->cascadeOnDelete();

            $table->string('name')->default('Primary Board');

            $table->string('board_type', 50)->default('default');

            $table->boolean('is_default')->default(true);

            $table->timestamp('last_saved_at')->nullable();

            $table->timestamps();

            $table->unique(['player_id', 'case_id', 'is_default'], 'ib_player_case_default_unique');
            $table->index(['player_id', 'case_id'], 'ib_player_case_index');
            $table->index(['case_id', 'updated_at'], 'ib_case_updated_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investigation_boards');
    }
};