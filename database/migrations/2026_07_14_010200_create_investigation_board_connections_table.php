<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investigation_board_connections', function (Blueprint $table) {
            $table->id();

            $table->foreignId('investigation_board_id')
                ->constrained('investigation_boards')
                ->cascadeOnDelete();

            $table->foreignId('source_board_item_id')
                ->constrained('investigation_board_items')
                ->cascadeOnDelete();

            $table->foreignId('target_board_item_id')
                ->constrained('investigation_board_items')
                ->cascadeOnDelete();

            $table->text('reason')->nullable();
            $table->string('confidence_level', 20);

            $table->timestamps();

            $table->unique(
                [
                    'investigation_board_id',
                    'source_board_item_id',
                    'target_board_item_id',
                ],
                'board_connections_unique_pair'
            );

            $table->index('investigation_board_id', 'board_connections_board_index');
            $table->index('source_board_item_id', 'board_connections_source_index');
            $table->index('target_board_item_id', 'board_connections_target_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investigation_board_connections');
    }
};