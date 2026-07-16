<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mission_codes', function (Blueprint $table) {

            $table->id();

            $table->foreignId('case_id')->constrained('cases')->cascadeOnDelete();

            $table->string('activation_code')->unique();

            $table->boolean('used')->default(false);

            $table->foreignId('used_by')->nullable()->constrained('players')->nullOnDelete();

            $table->timestamp('activated_at')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mission_codes');
    }
};