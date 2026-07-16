<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('case_files', 'file_type')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->dropColumn('file_type');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('case_files', 'file_type')) {
            Schema::table('case_files', function (Blueprint $table) {
                $table->string('file_type')->nullable()->after('case_id');
            });
        }
    }
};