<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Remove existing duplicate payments (keep the latest row per teacher/month/year).
        $duplicates = DB::table('salaries')
            ->select('teacher_id', 'month', 'year')
            ->groupBy('teacher_id', 'month', 'year')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicates as $duplicate) {
            $ids = DB::table('salaries')
                ->where('teacher_id', $duplicate->teacher_id)
                ->where('month', $duplicate->month)
                ->where('year', $duplicate->year)
                ->orderBy('id')
                ->pluck('id')
                ->toArray();

            $keep = array_pop($ids);

            DB::table('salaries')->whereIn('id', $ids)->delete();
        }

        Schema::table('salaries', function (Blueprint $table) {
            $table->unique(['teacher_id', 'month', 'year']);
        });
    }

    public function down(): void
    {
        Schema::table('salaries', function (Blueprint $table) {
            $table->dropUnique(['teacher_id', 'month', 'year']);
        });
    }
};
