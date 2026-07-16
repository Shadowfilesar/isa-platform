<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('players', function (Blueprint $table) {
            if (! Schema::hasColumn('players', 'xp')) {
                $table->unsignedInteger('xp')->default(0)->after('status');
            }

            if (! Schema::hasColumn('players', 'total_xp')) {
                $table->unsignedInteger('total_xp')->default(0)->after('xp');
            }
        });

        Schema::create('xp_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained('players')->cascadeOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->enum('type', ['award', 'remove']);
            $table->unsignedInteger('amount');
            $table->unsignedInteger('balance_before');
            $table->unsignedInteger('balance_after');
            $table->string('reason', 255);
            $table->longText('details')->nullable();
            $table->timestamps();

            $table->index(['player_id', 'created_at']);
            $table->index(['admin_id', 'created_at']);
            $table->index(['type', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('xp_logs');

        Schema::table('players', function (Blueprint $table) {
            if (Schema::hasColumn('players', 'total_xp')) {
                $table->dropColumn('total_xp');
            }

            if (Schema::hasColumn('players', 'xp')) {
                $table->dropColumn('xp');
            }
        });
    }
};