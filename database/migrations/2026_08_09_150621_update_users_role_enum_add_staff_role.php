<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");
            DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('admin', 'teacher', 'student', 'staff'))");
        } else {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['admin', 'teacher', 'student', 'staff'])->default('student')->change();
            });
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");
            DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('admin', 'teacher', 'student'))");
        } else {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['admin', 'teacher', 'student'])->default('student')->change();
            });
        }
    }
};
