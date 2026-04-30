<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->string('teacher_id_number')->unique()->nullable()->after('id');
        });

        // Generate IDs for existing teachers
        $teachers = App\Models\Teacher::all();
        foreach ($teachers as $teacher) {
            $teacher->teacher_id_number = 'T-' . str_pad($teacher->id, 4, '0', STR_PAD_LEFT);
            $teacher->save();
        }
    }

    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn('teacher_id_number');
        });
    }
};
