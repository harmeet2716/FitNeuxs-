<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fitness_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Step 1
            $table->enum('goal', ['fat_loss', 'muscle_gain', 'strength']);

            // Step 2
            $table->enum('gender', ['male', 'female']);
            $table->unsignedTinyInteger('age');
            $table->decimal('weight_kg', 6, 2);
            $table->decimal('height_cm', 6, 2);

            // Step 3
            $table->enum('activity_level', ['beginner', 'intermediate', 'advanced']);
            $table->unsignedTinyInteger('days_per_week');

            // Step 4
            $table->text('motivation');

            // Step 5
            $table->string('source')->nullable();

            // Calculated results
            $table->decimal('bmi', 5, 2);
            $table->decimal('body_fat_percent', 5, 2);
            $table->decimal('lean_mass_kg', 6, 2);
            $table->unsignedSmallInteger('bmr');
            $table->unsignedSmallInteger('tdee');
            $table->unsignedSmallInteger('target_calories');
            $table->unsignedSmallInteger('protein_g');
            $table->unsignedSmallInteger('carbs_g');
            $table->unsignedSmallInteger('fats_g');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fitness_profiles');
    }
};
