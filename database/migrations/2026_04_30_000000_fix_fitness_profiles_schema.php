<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fitness_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('fitness_profiles', 'gender')) {
                $table->enum('gender', ['male', 'female'])->nullable()->after('goal');
            }

            if (!Schema::hasColumn('fitness_profiles', 'weight_kg')) {
                $table->decimal('weight_kg', 6, 2)->nullable()->after('age');
            }

            if (!Schema::hasColumn('fitness_profiles', 'height_cm')) {
                $table->decimal('height_cm', 6, 2)->nullable()->after('weight_kg');
            }
        });

        if (Schema::hasColumn('fitness_profiles', 'weight')) {
            DB::table('fitness_profiles')->whereNull('weight_kg')->update([
                'weight_kg' => DB::raw('weight'),
            ]);
        }

        if (Schema::hasColumn('fitness_profiles', 'height')) {
            DB::table('fitness_profiles')->whereNull('height_cm')->update([
                'height_cm' => DB::raw('height'),
            ]);
        }

        if (Schema::hasColumn('fitness_profiles', 'gender')) {
            DB::table('fitness_profiles')->whereNull('gender')->update(['gender' => 'male']);
        }
    }

    public function down(): void
    {
        Schema::table('fitness_profiles', function (Blueprint $table) {
            if (Schema::hasColumn('fitness_profiles', 'gender')) {
                $table->dropColumn('gender');
            }

            if (Schema::hasColumn('fitness_profiles', 'weight_kg')) {
                $table->dropColumn('weight_kg');
            }

            if (Schema::hasColumn('fitness_profiles', 'height_cm')) {
                $table->dropColumn('height_cm');
            }
        });
    }
};
