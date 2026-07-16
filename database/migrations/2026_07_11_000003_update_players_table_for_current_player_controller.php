<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('players', 'username')) {
            Schema::table('players', function (Blueprint $table) {
                $table->string('username')->nullable()->after('id');
            });
        }

        if (! Schema::hasColumn('players', 'account_code')) {
            Schema::table('players', function (Blueprint $table) {
                $table->string('account_code')->nullable()->after('username');
            });
        }

        if (! Schema::hasColumn('players', 'password')) {
            Schema::table('players', function (Blueprint $table) {
                $table->string('password')->nullable()->after('account_code');
            });
        }

        if (! Schema::hasColumn('players', 'rank')) {
            Schema::table('players', function (Blueprint $table) {
                $table->string('rank')->nullable()->after('password');
            });
        }

        if (! Schema::hasColumn('players', 'clearance_level')) {
            Schema::table('players', function (Blueprint $table) {
                $table->string('clearance_level')->nullable()->after('rank');
            });
        }

        if (! Schema::hasColumn('players', 'status')) {
            Schema::table('players', function (Blueprint $table) {
                $table->string('status')->default('inactive')->after('clearance_level');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('players', 'status')) {
            Schema::table('players', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }

        if (Schema::hasColumn('players', 'clearance_level')) {
            Schema::table('players', function (Blueprint $table) {
                $table->dropColumn('clearance_level');
            });
        }

        if (Schema::hasColumn('players', 'rank')) {
            Schema::table('players', function (Blueprint $table) {
                $table->dropColumn('rank');
            });
        }

        if (Schema::hasColumn('players', 'password')) {
            Schema::table('players', function (Blueprint $table) {
                $table->dropColumn('password');
            });
        }

        if (Schema::hasColumn('players', 'account_code')) {
            Schema::table('players', function (Blueprint $table) {
                $table->dropColumn('account_code');
            });
        }

        if (Schema::hasColumn('players', 'username')) {
            Schema::table('players', function (Blueprint $table) {
                $table->dropColumn('username');
            });
        }
    }
};