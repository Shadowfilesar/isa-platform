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

        $table->foreignId('case_id')
            ->constrained('cases')
            ->cascadeOnDelete();

        $table->string('category')->default('documents');

        $table->string('section');

        $table->string('title');

        $table->text('description')->nullable();

        $table->string('file_name');

        $table->string('original_name');

        $table->string('mime_type');

        $table->unsignedBigInteger('file_size');

        $table->string('extension',20);

        $table->string('file_path');

        $table->integer('display_order')->default(1);

        $table->boolean('locked')->default(false);

        $table->boolean('public')->default(false);

        $table->string('unlock_event')->nullable();

        $table->integer('required_rank')->default(0);

        $table->integer('required_clearance')->default(0);

        $table->foreignId('uploaded_by')
            ->nullable()
            ->constrained('players')
            ->nullOnDelete();

        $table->foreignId('updated_by')
            ->nullable()
            ->constrained('players')
            ->nullOnDelete();

        $table->unsignedBigInteger('preview_count')->default(0);

        $table->unsignedBigInteger('download_count')->default(0);

        $table->string('sha256',64)->nullable();

        $table->unsignedBigInteger('parent_file_id')->nullable();

        $table->unsignedInteger('version')->default(1);

        $table->boolean('is_current')->default(true);

        $table->timestamps();

    });
}
};