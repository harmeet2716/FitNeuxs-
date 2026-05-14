<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProgressController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $user = Auth::user();

        if (! $user->fitnessProfile) {
            return redirect()->route('onboarding');
        }

        if (! $user->selectedProgram) {
            return redirect()->route('programs.index');
        }

        $history = $user->progress()->orderBy('date')->get();
        $totalCompleted = $history->sum('completed_workouts');
        $currentStreak = $history->last()?->streak ?? 0;

        return view('progress.index', [
            'history' => $history,
            'totalCompleted' => $totalCompleted,
            'currentStreak' => $currentStreak,
            'program' => $user->selectedProgram,
        ]);
    }
}
