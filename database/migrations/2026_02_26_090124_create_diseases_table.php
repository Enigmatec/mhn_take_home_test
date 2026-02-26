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
        Schema::create('diseases', function (Blueprint $table) {
            $table->id();
            // $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained('users', 'id');
            $table->string('name');
            $table->string('description');
            $table->string('category');
            $table->string('cat_id');
            $table->string('grade_code');
            $table->string('disease_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diseases');
    }
};
