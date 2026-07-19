<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('case_files', function (Blueprint $table) {

            $table->id();

            $table->foreignId('case_id')->constrained('cases')->cascadeOnDelete();

            $table->string('section');

            $table->string('title');

            $table->text('description')->nullable();

            $table->string('file_type');

            $table->string('file_path');

            $table->integer('display_order')->default(1);

            $table->boolean('locked')->default(false);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('case_files');
    }
};