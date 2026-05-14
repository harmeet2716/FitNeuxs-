<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->decimal('weight', 6, 2)->nullable();
            $table->unsignedSmallInteger('completed_workouts')->default(0);
            $table->unsignedSmallInteger('streak')->default(0);
            $table->timestamps();
            $table->unique(['user_id', 'date'], 'user_progress_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_progress');
    }
};
