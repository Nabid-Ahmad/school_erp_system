<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        DB::table('settings')->insert([
            ['key' => 'school_name', 'value' => 'Bangla Model School'],
            ['key' => 'school_address', 'value' => '123 School Road, Dhaka, Bangladesh'],
            ['key' => 'school_phone', 'value' => '+880 1711 223 344'],
            ['key' => 'school_email', 'value' => 'info@banglamodel.edu.bd'],
            ['key' => 'school_logo', 'value' => null],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
