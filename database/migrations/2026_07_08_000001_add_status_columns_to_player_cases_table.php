<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('player_cases', function (Blueprint $table) {

            $table->string('status')
                ->default('assigned')
                ->after('case_id');

            $table->timestamp('assigned_at')
                ->nullable()
                ->after('status');

            $table->timestamp('started_at')
                ->nullable()
                ->after('assigned_at');

            $table->timestamp('completed_at')
                ->nullable()
                ->after('started_at');

        });
    }

    public function down(): void
    {
        Schema::table('player_cases', function (Blueprint $table) {

            $table->dropColumn([
                'status',
                'assigned_at',
                'started_at',
                'completed_at',
            ]);

        });
    }
};