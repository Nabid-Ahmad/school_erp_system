<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $box) {
            $box->id();
            $box->string('title');
            $box->decimal('amount', 10, 2);
            $box->string('category'); // e.g., Utilities, Salary, Supplies
            $box->date('date');
            $box->text('description')->nullable();
            $box->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
