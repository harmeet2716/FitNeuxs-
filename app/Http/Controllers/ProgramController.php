<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\UserProgram;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProgramController extends Controller
{
    public function index(): View
    {
        return view('programs.index', [
            'programs' => Program::all(),
            'currentProgram' => Auth::user()->selectedProgram,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $program = Program::findOrFail($request->validate([
            'program_id' => ['required', 'exists:programs,id'],
        ])['program_id']);

        UserProgram::updateOrCreate(
            ['user_id' => Auth::id()],
            ['program_id' => $program->id]
        );

        return redirect()->route('dashboard')
            ->with('success', "{$program->name} is ready. Let's start training.");
    }
}
