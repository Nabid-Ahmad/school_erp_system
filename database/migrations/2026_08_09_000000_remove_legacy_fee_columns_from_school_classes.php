<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Backfill fee_structures from the legacy columns before dropping them.
        $classes = DB::table('school_classes')
            ->where(function ($query) {
                $query->where('monthly_fee', '>', 0)->orWhere('admission_fee', '>', 0);
            })
            ->get();

        foreach ($classes as $class) {
            foreach (['Monthly Fee' => 'monthly_fee', 'Admission Fee' => 'admission_fee'] as $type => $column) {
                $amount = $class->{$column};

                if ((float) $amount <= 0) {
                    continue;
                }

                $exists = DB::table('fee_structures')
                    ->where('school_class_id', $class->id)
                    ->where('fee_type', $type)
                    ->exists();

                if (! $exists) {
                    DB::table('fee_structures')->insert([
                        'school_class_id' => $class->id,
                        'fee_type' => $type,
                        'amount' => $amount,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        Schema::table('school_classes', function (Blueprint $table) {
            $table->dropColumn(['monthly_fee', 'admission_fee']);
        });
    }

    public function down(): void
    {
        Schema::table('school_classes', function (Blueprint $table) {
            $table->decimal('monthly_fee', 10, 2)->default(0)->after('name');
            $table->decimal('admission_fee', 10, 2)->default(0)->after('monthly_fee');
        });
    }
};
