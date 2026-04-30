<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            // Add only missing columns
            if (!Schema::hasColumn('teachers', 'designation')) {
                $table->string('designation')->nullable()->after('name');
            }
            if (!Schema::hasColumn('teachers', 'salary')) {
                $table->decimal('salary', 10, 2)->default(0)->after('image');
            }
            if (!Schema::hasColumn('teachers', 'joining_date')) {
                $table->date('joining_date')->nullable()->after('salary');
            }
        });
    }

    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn(['salary', 'joining_date']);
        });
    }
};
