<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('case_files', 'category')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->string('category', 50)->nullable()->after('case_id');
            });
        }

        if (! Schema::hasColumn('case_files', 'section')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->string('section', 100)->nullable()->after('category');
            });
        }

        if (! Schema::hasColumn('case_files', 'title')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->string('title')->nullable()->after('section');
            });
        }

        if (! Schema::hasColumn('case_files', 'description')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->text('description')->nullable()->after('title');
            });
        }

        if (! Schema::hasColumn('case_files', 'file_name')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->string('file_name')->nullable()->after('description');
            });
        }

        if (! Schema::hasColumn('case_files', 'original_name')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->string('original_name')->nullable()->after('file_name');
            });
        }

        if (! Schema::hasColumn('case_files', 'mime_type')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->string('mime_type')->nullable()->after('original_name');
            });
        }

        if (! Schema::hasColumn('case_files', 'file_size')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->unsignedBigInteger('file_size')->default(0)->after('mime_type');
            });
        }

        if (! Schema::hasColumn('case_files', 'extension')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->string('extension', 50)->nullable()->after('file_size');
            });
        }

        if (! Schema::hasColumn('case_files', 'file_path')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->string('file_path')->nullable()->after('extension');
            });
        }

        if (! Schema::hasColumn('case_files', 'display_order')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->unsignedInteger('display_order')->default(0)->after('file_path');
            });
        }

        if (! Schema::hasColumn('case_files', 'locked')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->boolean('locked')->default(false)->after('display_order');
            });
        }

        if (! Schema::hasColumn('case_files', 'public')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->boolean('public')->default(false)->after('locked');
            });
        }

        if (! Schema::hasColumn('case_files', 'unlock_event')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->string('unlock_event')->nullable()->after('public');
            });
        }

        if (! Schema::hasColumn('case_files', 'required_rank')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->string('required_rank')->nullable()->after('unlock_event');
            });
        }

        if (! Schema::hasColumn('case_files', 'required_clearance')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->string('required_clearance')->nullable()->after('required_rank');
            });
        }

        if (! Schema::hasColumn('case_files', 'uploaded_by')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->unsignedBigInteger('uploaded_by')->nullable()->after('required_clearance');
            });
        }

        if (! Schema::hasColumn('case_files', 'updated_by')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->unsignedBigInteger('updated_by')->nullable()->after('uploaded_by');
            });
        }

        if (! Schema::hasColumn('case_files', 'preview_count')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->unsignedInteger('preview_count')->default(0)->after('updated_by');
            });
        }

        if (! Schema::hasColumn('case_files', 'download_count')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->unsignedInteger('download_count')->default(0)->after('preview_count');
            });
        }

        if (! Schema::hasColumn('case_files', 'sha256')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->string('sha256', 64)->nullable()->after('download_count');
            });
        }

        if (! Schema::hasColumn('case_files', 'parent_file_id')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->unsignedBigInteger('parent_file_id')->nullable()->after('sha256');
            });
        }

        if (! Schema::hasColumn('case_files', 'version')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->unsignedInteger('version')->default(1)->after('parent_file_id');
            });
        }

        if (! Schema::hasColumn('case_files', 'is_current')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->boolean('is_current')->default(true)->after('version');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('case_files', 'is_current')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->dropColumn('is_current');
            });
        }

        if (Schema::hasColumn('case_files', 'version')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->dropColumn('version');
            });
        }

        if (Schema::hasColumn('case_files', 'parent_file_id')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->dropColumn('parent_file_id');
            });
        }

        if (Schema::hasColumn('case_files', 'sha256')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->dropColumn('sha256');
            });
        }

        if (Schema::hasColumn('case_files', 'download_count')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->dropColumn('download_count');
            });
        }

        if (Schema::hasColumn('case_files', 'preview_count')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->dropColumn('preview_count');
            });
        }

        if (Schema::hasColumn('case_files', 'updated_by')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->dropColumn('updated_by');
            });
        }

        if (Schema::hasColumn('case_files', 'uploaded_by')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->dropColumn('uploaded_by');
            });
        }

        if (Schema::hasColumn('case_files', 'required_clearance')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->dropColumn('required_clearance');
            });
        }

        if (Schema::hasColumn('case_files', 'required_rank')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->dropColumn('required_rank');
            });
        }

        if (Schema::hasColumn('case_files', 'unlock_event')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->dropColumn('unlock_event');
            });
        }

        if (Schema::hasColumn('case_files', 'public')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->dropColumn('public');
            });
        }

        if (Schema::hasColumn('case_files', 'locked')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->dropColumn('locked');
            });
        }

        if (Schema::hasColumn('case_files', 'display_order')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->dropColumn('display_order');
            });
        }

        if (Schema::hasColumn('case_files', 'file_path')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->dropColumn('file_path');
            });
        }

        if (Schema::hasColumn('case_files', 'extension')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->dropColumn('extension');
            });
        }

        if (Schema::hasColumn('case_files', 'file_size')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->dropColumn('file_size');
            });
        }

        if (Schema::hasColumn('case_files', 'mime_type')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->dropColumn('mime_type');
            });
        }

        if (Schema::hasColumn('case_files', 'original_name')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->dropColumn('original_name');
            });
        }

        if (Schema::hasColumn('case_files', 'file_name')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->dropColumn('file_name');
            });
        }

        if (Schema::hasColumn('case_files', 'description')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->dropColumn('description');
            });
        }

        if (Schema::hasColumn('case_files', 'title')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->dropColumn('title');
            });
        }

        if (Schema::hasColumn('case_files', 'section')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->dropColumn('section');
            });
        }

        if (Schema::hasColumn('case_files', 'category')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->dropColumn('category');
            });
        }
    }
};