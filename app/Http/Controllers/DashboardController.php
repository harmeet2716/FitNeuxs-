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

        return view('dashboard', ['profile' => $user->fitnessProfile]);
    }
}
