<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $user = Auth::user();

        if (! $user->fitnessProfile) {
            return redirect()->route('onboarding');
        }

        $program = $user->selectedProgram;
        
        if ($program) {
            $totalCompleted = $user->progress()->sum('completed_workouts');
            $workoutCount = max(1, $program->workouts()->count());
            $nextDay = ($totalCompleted % $workoutCount) + 1;
            $nextWorkout = $program->workouts()->where('day_number', $nextDay)->first();
            $streak = $user->progress()->latest('date')->first()?->streak ?? 0;
        } else {
            $totalCompleted = 0;
            $workoutCount = 1;
            $nextDay = 1;
            $nextWorkout = null;
            $streak = 0;
        }

        // Functional Stats Calculations
        $today = now()->toDateString();
        $startOfWeek = now()->startOfWeek()->toDateString();
        $endOfWeek = now()->endOfWeek()->toDateString();

        $weeklyProgressRecords = $user->progress()
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->get();

        $workoutsThisWeek = $weeklyProgressRecords->sum('completed_workouts');
        $targetDays = max(1, $user->fitnessProfile->days_per_week);
        $weeklyProgressPercent = min(100, round(($workoutsThisWeek / $targetDays) * 100));

        $todayProgress = $weeklyProgressRecords->where('date', $today)->first();
        $todayWorkouts = $todayProgress ? $todayProgress->completed_workouts : 0;
        
        // Estimate 320 kcal per completed workout
        $todayCaloriesBurned = $todayWorkouts * 320;
        
        $targetDailyCalories = $user->fitnessProfile->target_calories;
        // Burn percent relative to a reasonable exercise calorie target (e.g. 500 kcal per day)
        $burnPercent = min(100, round(($todayCaloriesBurned / 500) * 100));

        // Generate mock bar chart data for the week based on progress records
        $chartData = [];
        $days = ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'];
        for ($i = 0; $i < 7; $i++) {
            $dateString = now()->startOfWeek()->addDays($i)->toDateString();
            $record = $weeklyProgressRecords->where('date', $dateString)->first();
            $wks = $record ? $record->completed_workouts : 0;
            // random height between 10% and 30% for rest days, plus workouts
            $chartData[$days[$i]] = min(100, rand(10, 30) + ($wks * 40)); 
        }

        return view('dashboard', [
            'profile' => $user->fitnessProfile,
            'program' => $program,
            'nextWorkout' => $nextWorkout,
            'nextDay' => $nextDay,
            'totalWorkoutDays' => $workoutCount,
            'totalCompleted' => $totalCompleted,
            'streak' => $streak,
            'weeklyProgressPercent' => $weeklyProgressPercent,
            'burnPercent' => $burnPercent,
            'todayCaloriesBurned' => $todayCaloriesBurned,
            'chartData' => $chartData,
        ]);
    }
}
