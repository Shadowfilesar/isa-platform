<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('players', function (Blueprint $table) {

            if (! Schema::hasColumn('players', 'clearance_level')) {

                $table->string('clearance_level')
                    ->default('C')
                    ->after('rank');

            }

            if (! Schema::hasColumn('players', 'is_active')) {

                $table->boolean('is_active')
                    ->default(true)
                    ->after('clearance_level');

            }

        });
    }

    public function down(): void
    {
        Schema::table('players', function (Blueprint $table) {

            if (Schema::hasColumn('players', 'is_active')) {

                $table->dropColumn('is_active');

            }

            if (Schema::hasColumn('players', 'clearance_level')) {

                $table->dropColumn('clearance_level');

            }

        });
    }
};