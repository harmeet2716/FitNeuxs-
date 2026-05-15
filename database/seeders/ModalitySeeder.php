<?php

namespace Database\Seeders;

use App\Models\Modality;
use Illuminate\Database\Seeder;

class ModalitySeeder extends Seeder
{
    public function run(): void
    {
        $modalities = [
            [
                'name' => 'Bodybuilding',
                'slug' => 'bodybuilding',
                'icon' => 'Dumbbell',
                'color' => 'cyan',
                'description' => 'Hypertrophy focused training for maximum muscle growth.'
            ],
            [
                'name' => 'Powerlifting',
                'slug' => 'powerlifting',
                'icon' => 'Weight',
                'color' => 'violet',
                'description' => 'Focus on the Big Three: Squat, Bench, and Deadlift.'
            ],
            [
                'name' => 'Calisthenics',
                'slug' => 'calisthenics',
                'icon' => 'User',
                'color' => 'blue',
                'description' => 'Master your bodyweight with elite gymnastic movements.'
            ],
            [
                'name' => 'Yoga',
                'slug' => 'yoga',
                'icon' => 'Zap',
                'color' => 'emerald',
                'description' => 'Mind-body connection with focus on flexibility and core.'
            ],
            [
                'name' => 'Cardio',
                'slug' => 'cardio',
                'icon' => 'Activity',
                'color' => 'rose',
                'description' => 'Endurance training to push your cardiovascular limits.'
            ],
            [
                'name' => 'HIIT',
                'slug' => 'hiit',
                'icon' => 'Flame',
                'color' => 'orange',
                'description' => 'High Intensity Interval Training for metabolic fire.'
            ],
            [
                'name' => 'Mobility',
                'slug' => 'mobility',
                'icon' => 'Move',
                'color' => 'indigo',
                'description' => 'Restore joint health and improve functional range.'
            ],
            [
                'name' => 'Sports',
                'slug' => 'athletics',
                'icon' => 'Trophy',
                'color' => 'yellow',
                'description' => 'Performance metrics for competitive athletic output.'
            ],
        ];

        foreach ($modalities as $modality) {
            Modality::updateOrCreate(['slug' => $modality['slug']], $modality);
        }
    }
}
