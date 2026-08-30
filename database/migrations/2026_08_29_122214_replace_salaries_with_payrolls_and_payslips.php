<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Drop foreign key from expenses if it exists
        if (Schema::hasColumn('expenses', 'salary_id')) {
            Schema::table('expenses', function (Blueprint $table) {
                $table->dropForeign(['salary_id']);
                $table->dropColumn('salary_id');
            });
        }

        // 2. Drop salaries table
        Schema::dropIfExists('salaries');

        // 3. Create payrolls table
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->string('month');
            $table->integer('year');
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->string('status')->default('draft'); // draft, published
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // 4. Create payslips table
        Schema::create('payslips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payroll_id')->constrained()->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
            $table->decimal('basic_salary', 10, 2)->default(0);
            $table->decimal('allowance', 10, 2)->default(0);
            $table->decimal('deduction', 10, 2)->default(0);
            $table->decimal('net_salary', 10, 2)->default(0);
            $table->string('status')->default('unpaid'); // unpaid, paid
            $table->date('payment_date')->nullable();
            $table->timestamps();
        });

        // 5. Add payslip_id to expenses
        Schema::table('expenses', function (Blueprint $table) {
            $table->foreignId('payslip_id')->nullable()->after('id')->constrained('payslips')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        // Rollback is destructive since we dropped old data, but we provide schema rollback
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign(['payslip_id']);
            $table->dropColumn('payslip_id');
        });

        Schema::dropIfExists('payslips');
        Schema::dropIfExists('payrolls');

        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('month');
            $table->string('year');
            $table->date('payment_date');
            $table->string('status')->default('paid');
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->foreignId('salary_id')->nullable()->after('id')->constrained('salaries')->cascadeOnDelete();
        });
    }

};         
