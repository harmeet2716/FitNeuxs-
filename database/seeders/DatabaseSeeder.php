<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\Program;
use App\Models\User;
use App\Models\Workout;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $programs = [
            [
                'name' => 'Fat Loss Program',
                'goal' => 'fat_loss',
                'duration_weeks' => 6,
                'difficulty' => 'Moderate',
                'summary' => 'A fat-burning program focused on cardio, full-body conditioning and metabolic tempo.',
                'workouts' => [
                    ['day' => 1, 'title' => 'Full Body Burn', 'description' => 'High-intensity compounds for fat loss', 'exercises' => [
                        ['name' => 'Jump Squats', 'sets' => '4', 'reps' => '12', 'rest_time' => '45 sec'],
                        ['name' => 'Push-up to T', 'sets' => '4', 'reps' => '10', 'rest_time' => '45 sec'],
                        ['name' => 'Kettlebell Swings', 'sets' => '4', 'reps' => '15', 'rest_time' => '50 sec'],
                    ]],
                    ['day' => 2, 'title' => 'Cardio and Core', 'description' => 'Timed intervals to raise your heart rate.', 'exercises' => [
                        ['name' => 'Mountain Climbers', 'sets' => '4', 'reps' => '40 sec', 'rest_time' => '40 sec'],
                        ['name' => 'High Knees', 'sets' => '4', 'reps' => '30 sec', 'rest_time' => '40 sec'],
                        ['name' => 'Plank Hold', 'sets' => '3', 'reps' => '60 sec', 'rest_time' => '45 sec'],
                    ]],
                    ['day' => 3, 'title' => 'Strength and Sweat', 'description' => 'Sculpt while burning calories.', 'exercises' => [
                        ['name' => 'Dumbbell Reverse Lunges', 'sets' => '4', 'reps' => '12 each', 'rest_time' => '60 sec'],
                        ['name' => 'Bent-over Rows', 'sets' => '4', 'reps' => '10', 'rest_time' => '60 sec'],
                        ['name' => 'Burpees', 'sets' => '3', 'reps' => '12', 'rest_time' => '60 sec'],
                    ]],
                ],
            ],
            [
                'name' => 'Muscle Gain Program',
                'goal' => 'muscle_gain',
                'duration_weeks' => 8,
                'difficulty' => 'Challenging',
                'summary' => 'A hypertrophy-driven program with push, pull, and leg sessions for muscle growth.',
                'workouts' => [
                    ['day' => 1, 'title' => 'Push Power', 'description' => 'Chest, shoulders and triceps focus.', 'exercises' => [
                        ['name' => 'Barbell Bench Press', 'sets' => '5', 'reps' => '8', 'rest_time' => '90 sec'],
                        ['name' => 'Overhead Press', 'sets' => '4', 'reps' => '10', 'rest_time' => '90 sec'],
                        ['name' => 'Tricep Dips', 'sets' => '4', 'reps' => '12', 'rest_time' => '60 sec'],
                    ]],
                    ['day' => 2, 'title' => 'Pull Focus', 'description' => 'Build back width and strength.', 'exercises' => [
                        ['name' => 'Pull-ups', 'sets' => '4', 'reps' => '8', 'rest_time' => '90 sec'],
                        ['name' => 'Dumbbell Rows', 'sets' => '4', 'reps' => '10', 'rest_time' => '75 sec'],
                        ['name' => 'Bicep Curls', 'sets' => '4', 'reps' => '12', 'rest_time' => '60 sec'],
                    ]],
                    ['day' => 3, 'title' => 'Leg Day', 'description' => 'Train the lower body with volume and strength.', 'exercises' => [
                        ['name' => 'Back Squats', 'sets' => '5', 'reps' => '8', 'rest_time' => '120 sec'],
                        ['name' => 'Romanian Deadlifts', 'sets' => '4', 'reps' => '10', 'rest_time' => '90 sec'],
                        ['name' => 'Leg Press', 'sets' => '4', 'reps' => '12', 'rest_time' => '90 sec'],
                    ]],
                ],
            ],
            [
                'name' => 'Strength Program',
                'goal' => 'strength',
                'duration_weeks' => 6,
                'difficulty' => 'Advanced',
                'summary' => 'A compound-focused strength plan designed to raise your power and stability.',
                'workouts' => [
                    ['day' => 1, 'title' => 'Compound Core', 'description' => 'Heavy lifts for full-body strength.', 'exercises' => [
                        ['name' => 'Deadlift', 'sets' => '5', 'reps' => '5', 'rest_time' => '150 sec'],
                        ['name' => 'Front Squat', 'sets' => '4', 'reps' => '6', 'rest_time' => '120 sec'],
                        ['name' => 'Weighted Pull-ups', 'sets' => '4', 'reps' => '6', 'rest_time' => '120 sec'],
                    ]],
                    ['day' => 2, 'title' => 'Power Session', 'description' => 'Strength, speed, and stability.', 'exercises' => [
                        ['name' => 'Power Cleans', 'sets' => '4', 'reps' => '5', 'rest_time' => '120 sec'],
                        ['name' => 'Bench Press', 'sets' => '5', 'reps' => '5', 'rest_time' => '120 sec'],
                        ['name' => 'Farmer Carry', 'sets' => '3', 'reps' => '40 sec', 'rest_time' => '90 sec'],
                    ]],
                    ['day' => 3, 'title' => 'Strength Finish', 'description' => 'Bringing the program together with core stability.', 'exercises' => [
                        ['name' => 'Weighted Step-ups', 'sets' => '4', 'reps' => '8 each', 'rest_time' => '90 sec'],
                        ['name' => 'Incline Press', 'sets' => '4', 'reps' => '6', 'rest_time' => '90 sec'],
                        ['name' => 'Plank with Shoulder Tap', 'sets' => '3', 'reps' => '45 sec', 'rest_time' => '60 sec'],
                    ]],
                ],
            ],
        ];

        foreach ($programs as $programData) {
            $program = Program::create([
                'name' => $programData['name'],
                'goal' => $programData['goal'],
                'duration_weeks' => $programData['duration_weeks'],
                'difficulty' => $programData['difficulty'],
                'summary' => $programData['summary'],
            ]);

            foreach ($programData['workouts'] as $workoutData) {
                $workout = Workout::create([
                    'program_id' => $program->id,
                    'day_number' => $workoutData['day'],
                    'title' => $workoutData['title'],
                    'description' => $workoutData['description'],
                ]);

                foreach ($workoutData['exercises'] as $exerciseData) {
                    Exercise::create([
                        'workout_id' => $workout->id,
                        'name' => $exerciseData['name'],
                        'sets' => $exerciseData['sets'],
                        'reps' => $exerciseData['reps'],
                        'rest_time' => $exerciseData['rest_time'],
                    ]);
                }
            }
        }
    }
}
