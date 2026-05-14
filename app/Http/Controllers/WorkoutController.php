<?php

namespace App\Http\Controllers;

use App\Models\UserProgress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WorkoutController extends Controller
{
    public function index(): View
    {
        return view('workouts.index');
    }

    public function show(int $day): View|RedirectResponse
    {
        $user = Auth::user();

        if (! $user->fitnessProfile) {
            return redirect()->route('onboarding');
        }

        $program = $user->selectedProgram;

        if (! $program) {
            // Provide a dynamic mock workout if they haven't selected a program yet
            $program = new \App\Models\Program(['name' => 'Custom ' . ucfirst(str_replace('_', ' ', $user->fitnessProfile->goal)) . ' Plan']);
            $workout = new \App\Models\Workout(['title' => 'Full Body Activation', 'description' => 'A tailored daily routine.']);
            $workout->setRelation('exercises', collect([
                new \App\Models\Exercise(['name' => 'Dumbbell Squats', 'sets' => '3', 'reps' => '12', 'rest_time' => '60s']),
                new \App\Models\Exercise(['name' => 'Push Ups', 'sets' => '3', 'reps' => '15', 'rest_time' => '60s']),
                new \App\Models\Exercise(['name' => 'Bicep Curls', 'sets' => '3', 'reps' => '12', 'rest_time' => '45s']),
                new \App\Models\Exercise(['name' => 'Crunches', 'sets' => '3', 'reps' => '20', 'rest_time' => '30s']),
            ]));
        } else {
            $workout = $program->workouts()->with('exercises')->where('day_number', $day)->first();
            if (! $workout) {
                return redirect()->route('dashboard');
            }
        }

        return view('workout.show', [
            'program' => $program,
            'workout' => $workout,
            'day' => $day,
        ]);
    }

    public function complete(Request $request, int $day): RedirectResponse
    {
        $user = Auth::user();

        if (! $user->fitnessProfile) {
            return redirect()->route('onboarding');
        }

        $program = $user->selectedProgram;

        // If no program exists, we still log the completion!
        if ($program) {
            $workout = $program->workouts()->where('day_number', $day)->first();
            if (! $workout) {
                return redirect()->route('dashboard');
            }
        }

        $today = now()->startOfDay();
        $yesterday = UserProgress::where('user_id', Auth::id())
            ->where('date', $today->copy()->subDay())
            ->first();

        $progress = UserProgress::firstOrNew([
            'user_id' => Auth::id(),
            'date' => $today,
        ]);

        if (! $progress->exists) {
            $progress->streak = $yesterday ? $yesterday->streak + 1 : 1;
            $progress->weight = $user->fitnessProfile->weight_kg;
            $progress->completed_workouts = 1;
        } else {
            $progress->completed_workouts = max(1, $progress->completed_workouts + 1);
            $progress->streak = $progress->streak ?: ($yesterday ? $yesterday->streak + 1 : 1);
            $progress->weight = $progress->weight ?: $user->fitnessProfile->weight_kg;
        }

        $progress->save();

        return redirect()->route('workout.show', ['day' => $day])
            ->with('success', 'Workout marked complete. Keep the streak going!');
    }
}
