<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investigation_board_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('investigation_board_id')
                ->constrained('investigation_boards')
                ->cascadeOnDelete();

            $table->foreignId('case_file_id')
                ->constrained('case_files')
                ->cascadeOnDelete();

            $table->boolean('is_pinned')->default(true);

            $table->decimal('position_x', 12, 4)->default(0);

            $table->decimal('position_y', 12, 4)->default(0);

            $table->decimal('width', 12, 4)->nullable();

            $table->decimal('height', 12, 4)->nullable();

            $table->unsignedInteger('z_index')->default(0);

            $table->decimal('rotation', 8, 3)->default(0);

            $table->timestamp('pinned_at')->nullable();

            $table->timestamp('last_moved_at')->nullable();

            $table->timestamps();

            $table->unique(['investigation_board_id', 'case_file_id'], 'ibi_board_file_unique');
            $table->index(['investigation_board_id', 'is_pinned'], 'ibi_board_pinned_index');
            $table->index(['investigation_board_id', 'z_index'], 'ibi_board_z_index');
            $table->index(['case_file_id'], 'ibi_case_file_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investigation_board_items');
    }
};