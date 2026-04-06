<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('forget_passwords', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->foreignId('user_id')
                ->constrained() //reference id on user
                ->cascadeOnDelete();
            $table->string('token')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forget_passwords');
    }
};
