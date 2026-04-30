<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fitness_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('fitness_profiles', 'bmi')) {
                $table->decimal('bmi', 5, 2)->nullable()->after('source');
            }

            if (!Schema::hasColumn('fitness_profiles', 'body_fat_percent')) {
                $table->decimal('body_fat_percent', 5, 2)->nullable()->after('bmi');
            }

            if (!Schema::hasColumn('fitness_profiles', 'lean_mass_kg')) {
                $table->decimal('lean_mass_kg', 6, 2)->nullable()->after('body_fat_percent');
            }

            if (!Schema::hasColumn('fitness_profiles', 'bmr')) {
                $table->unsignedSmallInteger('bmr')->nullable()->after('lean_mass_kg');
            }

            if (!Schema::hasColumn('fitness_profiles', 'tdee')) {
                $table->unsignedSmallInteger('tdee')->nullable()->after('bmr');
            }

            if (!Schema::hasColumn('fitness_profiles', 'target_calories')) {
                $table->unsignedSmallInteger('target_calories')->nullable()->after('tdee');
            }

            if (!Schema::hasColumn('fitness_profiles', 'protein_g')) {
                $table->unsignedSmallInteger('protein_g')->nullable()->after('target_calories');
            }

            if (!Schema::hasColumn('fitness_profiles', 'carbs_g')) {
                $table->unsignedSmallInteger('carbs_g')->nullable()->after('protein_g');
            }

            if (!Schema::hasColumn('fitness_profiles', 'fats_g')) {
                $table->unsignedSmallInteger('fats_g')->nullable()->after('carbs_g');
            }
        });
    }

    public function down(): void
    {
        Schema::table('fitness_profiles', function (Blueprint $table) {
            if (Schema::hasColumn('fitness_profiles', 'fats_g')) {
                $table->dropColumn('fats_g');
            }

            if (Schema::hasColumn('fitness_profiles', 'carbs_g')) {
                $table->dropColumn('carbs_g');
            }

            if (Schema::hasColumn('fitness_profiles', 'protein_g')) {
                $table->dropColumn('protein_g');
            }

            if (Schema::hasColumn('fitness_profiles', 'target_calories')) {
                $table->dropColumn('target_calories');
            }

            if (Schema::hasColumn('fitness_profiles', 'tdee')) {
                $table->dropColumn('tdee');
            }

            if (Schema::hasColumn('fitness_profiles', 'bmr')) {
                $table->dropColumn('bmr');
            }

            if (Schema::hasColumn('fitness_profiles', 'lean_mass_kg')) {
                $table->dropColumn('lean_mass_kg');
            }

            if (Schema::hasColumn('fitness_profiles', 'body_fat_percent')) {
                $table->dropColumn('body_fat_percent');
            }

            if (Schema::hasColumn('fitness_profiles', 'bmi')) {
                $table->dropColumn('bmi');
            }
        });
    }
};
