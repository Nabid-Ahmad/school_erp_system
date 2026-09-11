<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // PostgreSQL approach if using Postgres, but usually SQLite or MySQL.
            // Safe approach for all databases (especially SQLite and PostgreSQL):
            if (DB::getDriverName() === 'pgsql') {
                DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");
                DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('admin', 'teacher', 'student', 'staff', 'subadmin'))");
            } else {
                $table->enum('role', ['admin', 'teacher', 'student', 'staff', 'subadmin'])->default('student')->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (DB::getDriverName() === 'pgsql') {
                DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");
                DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('admin', 'teacher', 'student', 'staff'))");
            } else {
                $table->enum('role', ['admin', 'teacher', 'student', 'staff'])->default('student')->change();
            }
        });
    }
};
