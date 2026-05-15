<?php

namespace App\Http\Controllers;

use App\Models\FitnessProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class FitnessProfileController extends Controller
{
    /**
     * Show the multi-step onboarding form.
     */
    public function create(): View
    {
        return view('onboarding');
    }

    /**
     * Validate, calculate, persist, then redirect to results.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'goal'            => ['required', 'in:lose_fat,build_muscle,maintenance'],
            'gender'          => ['required', 'in:male,female'],
            'age'             => ['required', 'integer', 'min:10', 'max:99'],
            'weight_kg'       => ['required', 'numeric', 'min:20', 'max:400'],
            'height_cm'       => ['required', 'numeric', 'min:50', 'max:280'],
            'activity_level'  => ['required', 'in:beginner,intermediate,advanced'],
        ]);

        $multipliers = [
            'beginner'     => 1.35,
            'intermediate' => 1.55,
            'advanced'     => 1.75,
        ];

        $activityMultiplier = $multipliers[$data['activity_level']];

        $age    = (int) $data['age'];
        $wKg    = (float) $data['weight_kg'];
        $hCm    = (float) $data['height_cm'];
        $hM     = $hCm / 100;
        $gender = $data['gender'];

        // ── BMI ───────────────────────────────────────────────────────────
        $bmi = round($wKg / ($hM * $hM), 2);

        // ── BMR (Mifflin-St Jeor) ─────────────────────────────────────────
        $bmr = $gender === 'male'
            ? (int) round(10 * $wKg + 6.25 * $hCm - 5 * $age + 5)
            : (int) round(10 * $wKg + 6.25 * $hCm - 5 * $age - 161);

        // ── TDEE ──────────────────────────────────────────────────────────
        $tdee = (int) round($bmr * $activityMultiplier);

        // ── Target Calories ───────────────────────────────────────────────
        $targetCalories = match ($data['goal']) {
            'lose_fat'    => (int) round($tdee * 0.82),
            'build_muscle' => (int) round($tdee * 1.10),
            default       => $tdee,
        };

        // ── Persist (Update FitnessProfile) ────────────────────────────
        $user = Auth::user();
        \App\Models\FitnessProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'goal'             => $data['goal'],
                'gender'           => $gender,
                'age'              => $age,
                'weight_kg'        => $wKg,
                'height_cm'        => $hCm,
                'activity_level'   => $data['activity_level'],
                'bmi'              => $bmi,
                'bmr'              => $bmr,
                'tdee'             => $tdee,
                'target_calories'  => $targetCalories,
            ]
        );

        return redirect()->route('dashboard')
                         ->with('success', 'Your fitness profile has been initialized! Welcome to FitNexus.');
    }

    /**
     * Update from profile page.
     */
    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'goal'            => ['required', 'in:fat_loss,muscle_gain,strength,stay_active,boost_energy'],
            'gender'          => ['required', 'in:male,female'],
            'age'             => ['required', 'integer', 'min:10', 'max:99'],
            'weight_kg'       => ['required', 'numeric', 'min:20', 'max:400'],
            'height_cm'       => ['required', 'numeric', 'min:50', 'max:280'],
            'activity_level'  => ['required', 'in:beginner,intermediate,advanced'],
            'days_per_week'   => ['required', 'integer', 'min:1', 'max:7'],
        ]);

        $multipliers = [
            'beginner'     => 1.35,
            'intermediate' => 1.55,
            'advanced'     => 1.75,
        ];

        $activityMultiplier = $multipliers[$data['activity_level']];

        $age    = (int) $data['age'];
        $wKg    = (float) $data['weight_kg'];
        $hCm    = (float) $data['height_cm'];
        $hM     = $hCm / 100;
        $gender = $data['gender'];

        // ── BMI ───────────────────────────────────────────────────────────
        $bmi = round($wKg / ($hM * $hM), 2);

        // ── BMR (Mifflin-St Jeor) ─────────────────────────────────────────
        $bmr = $gender === 'male'
            ? (int) round(10 * $wKg + 6.25 * $hCm - 5 * $age + 5)
            : (int) round(10 * $wKg + 6.25 * $hCm - 5 * $age - 161);

        // ── TDEE ──────────────────────────────────────────────────────────
        $tdee = (int) round($bmr * $activityMultiplier);

        // ── Estimated Body Fat % (Deurenberg) ────────────────────────────
        $bf = (1.20 * $bmi) + (0.23 * $age) - ($gender === 'male' ? 16.2 : 5.4);
        $bf = round(max(4, min(60, $bf)), 2);

        // ── Lean Mass ─────────────────────────────────────────────────────
        $leanMass = round($wKg * (1 - $bf / 100), 2);

        // ── Target Calories ───────────────────────────────────────────────
        $targetCalories = match ($data['goal']) {
            'fat_loss'    => (int) round($tdee * 0.82),
            'muscle_gain' => (int) round($tdee * 1.10),
            default       => $tdee,
        };

        // ── Macros ────────────────────────────────────────────────────────
        $protein  = (int) round($leanMass * 2.2);
        $fats     = (int) round($wKg * 0.88);
        $carbsCal = max(0, $targetCalories - ($protein * 4) - ($fats * 9));
        $carbs    = (int) round($carbsCal / 4);

        // ── Persist ────────────
        $profile = \App\Models\FitnessProfile::where('user_id', Auth::id())->firstOrFail();
        $profile->update([
            'goal'             => $data['goal'],
            'gender'           => $gender,
            'age'              => $age,
            'weight_kg'        => $wKg,
            'height_cm'        => $hCm,
            'activity_level'   => $data['activity_level'],
            'days_per_week'    => $data['days_per_week'],
            'bmi'              => $bmi,
            'body_fat_percent' => $bf,
            'lean_mass_kg'     => $leanMass,
            'bmr'              => $bmr,
            'tdee'             => $tdee,
            'target_calories'  => $targetCalories,
            'protein_g'        => $protein,
            'carbs_g'          => $carbs,
            'fats_g'           => $fats,
        ]);

        return redirect()->route('profile.edit')->with('status', 'fitness-updated');
    }

    /**
     * Display the results page for a saved profile.
     */
    public function show(FitnessProfile $fitnessProfile): View
    {
        // Authorise: only the owner can view their profile
        abort_if($fitnessProfile->user_id !== Auth::id(), 403);

        return view('fitness.show', ['profile' => $fitnessProfile]);
    }
}
