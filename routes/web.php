<?php

use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FitnessProfileController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/onboarding', [FitnessProfileController::class, 'create'])->name('onboarding');
    Route::get('/fitness-profile', [FitnessProfileController::class, 'create'])->name('fitness.create');
    Route::post('/fitness-profile', [FitnessProfileController::class, 'store'])->name('fitness.store');
    Route::patch('/fitness-profile', [FitnessProfileController::class, 'update'])->name('fitness.update');

    Route::get('/programs', [\App\Http\Controllers\ProgramController::class, 'index'])->name('programs.index');
    Route::post('/programs', [\App\Http\Controllers\ProgramController::class, 'store'])->name('programs.store');

    Route::get('/workouts', [\App\Http\Controllers\WorkoutController::class, 'index'])->name('workouts.index');
    Route::get('/workout/{day}', [\App\Http\Controllers\WorkoutController::class, 'show'])->name('workout.show');
    Route::post('/workout/{day}/complete', [\App\Http\Controllers\WorkoutController::class, 'complete'])->name('workout.complete');

    Route::get('/progress', [\App\Http\Controllers\ProgressController::class, 'index'])->name('progress.index');
    Route::get('/wellness', function() { return view('wellness'); })->name('wellness');
    Route::get('/ai-coach', function() { return view('ai-coach'); })->name('ai-coach');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/auth/google', [SocialLoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialLoginController::class, 'handleGoogleCallback'])->name('auth.google.callback');
