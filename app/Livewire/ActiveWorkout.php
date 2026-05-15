<?php

namespace App\Livewire;

use App\Models\WorkoutSession;
use App\Models\Modality;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ActiveWorkout extends Component
{
    public $isSessionActive = false;
    public $trainingType = '';
    public $exercises = []; // Array of {name: string, sets: [{weight: float, reps: int, rpe: int, is_pr: bool}]}
    public $startTime;
    public $totalVolume = 0;
    public $modalities = [];
    public $activeExercise = null; // Currently selected exercise for intelligence panel

    public $exerciseLibrary = [
        'Bench Press' => [
            'name' => 'Bench Press',
            'muscle_group' => 'Chest',
            'muscle_id' => 'chest',
            'demo_url' => 'https://assets.mixkit.co/videos/preview/mixkit-man-doing-bench-press-exercise-in-gym-23422-large.mp4',
            'tips' => 'Retract scapula, keep feet planted, drive bar in a slight arc.'
        ],
        'Back Squat' => [
            'name' => 'Back Squat',
            'muscle_group' => 'Legs',
            'muscle_id' => 'quads',
            'demo_url' => 'https://assets.mixkit.co/videos/preview/mixkit-man-doing-squats-with-barbell-in-gym-23423-large.mp4',
            'tips' => 'Hips back, knees out, keep chest up and core braced.'
        ],
        'Deadlift' => [
            'name' => 'Deadlift',
            'muscle_group' => 'Back',
            'muscle_id' => 'back',
            'demo_url' => 'https://assets.mixkit.co/videos/preview/mixkit-man-lifting-barbell-in-gym-23421-large.mp4',
            'tips' => 'Neutral spine, pull slack out of bar, drive through heels.'
        ],
        'Overhead Press' => [
            'name' => 'Overhead Press',
            'muscle_group' => 'Shoulders',
            'muscle_id' => 'shoulders',
            'demo_url' => 'https://assets.mixkit.co/videos/preview/mixkit-man-performing-overhead-press-with-barbell-23424-large.mp4',
            'tips' => 'Brace core, glutes tight, head back as bar passes face.'
        ]
    ];

    public function mount()
    {
        $this->modalities = Modality::all()->toArray();
        if (empty($this->modalities)) {
            // Fallback if seeder hasn't run
            $this->modalities = [
                ['id' => 'bodybuilding', 'name' => 'Bodybuilding', 'icon' => 'Dumbbell', 'color' => 'cyan'],
                ['id' => 'powerlifting', 'name' => 'Powerlifting', 'icon' => 'Weight', 'color' => 'violet'],
            ];
        }
    }

    public function selectExercise($index)
    {
        $name = $this->exercises[$index]['name'];
        if (isset($this->exerciseLibrary[$name])) {
            $this->activeExercise = $this->exerciseLibrary[$name];
        } else {
            // Generic info for unknown exercises
            $this->activeExercise = [
                'name' => $name,
                'muscle_group' => 'Full Body / Dynamic',
                'demo_url' => null,
                'tips' => 'Focus on controlled movement and proper breathing.'
            ];
        }
    }

    public function launchSession($type)
    {
        $this->trainingType = $type;
        $this->isSessionActive = true;
        $this->startTime = now();
        $this->exercises = [];
        $this->totalVolume = 0;
        $this->activeExercise = null;
    }

    public function addExercise($name = '')
    {
        $this->exercises[] = [
            'name' => $name ?: 'New Movement',
            'sets' => [
                ['weight' => '', 'reps' => '', 'rpe' => '', 'is_pr' => false]
            ]
        ];
    }

    public function addSet($exerciseIndex)
    {
        $this->exercises[$exerciseIndex]['sets'][] = [
            'weight' => '',
            'reps' => '',
            'rpe' => '',
            'is_pr' => false
        ];
        
        // Trigger Rest Timer on Frontend via browser event
        $this->dispatch('start-rest-timer', duration: 90);
        $this->dispatch('pulse-intelligence');
    }

    public function checkPR($exerciseIndex, $setIndex)
    {
        $exerciseName = $this->exercises[$exerciseIndex]['name'];
        $currentWeight = (float)($this->exercises[$exerciseIndex]['sets'][$setIndex]['weight'] ?? 0);

        if ($currentWeight <= 0) return;

        // Fetch previous sessions for this user and exercise
        $previousSession = WorkoutSession::where('user_id', Auth::id())
            ->where('status', 'completed')
            ->where('exercises.name', $exerciseName)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($previousSession) {
            $maxWeight = 0;
            foreach ($previousSession->exercises as $ex) {
                if ($ex['name'] === $exerciseName) {
                    foreach ($ex['sets'] as $set) {
                        $maxWeight = max($maxWeight, (float)$set['weight']);
                    }
                }
            }

            if ($currentWeight > $maxWeight) {
                $this->exercises[$exerciseIndex]['sets'][$setIndex]['is_pr'] = true;
            } else {
                $this->exercises[$exerciseIndex]['sets'][$setIndex]['is_pr'] = false;
            }
        }
        
        $this->calculateVolume();
    }

    public function removeSet($exerciseIndex, $setIndex)
    {
        unset($this->exercises[$exerciseIndex]['sets'][$setIndex]);
        $this->exercises[$exerciseIndex]['sets'] = array_values($this->exercises[$exerciseIndex]['sets']);
        
        if (empty($this->exercises[$exerciseIndex]['sets'])) {
            unset($this->exercises[$exerciseIndex]);
            $this->exercises = array_values($this->exercises);
        }
        
        $this->calculateVolume();
    }

    public function calculateVolume()
    {
        $volume = 0;
        foreach ($this->exercises as $exercise) {
            foreach ($exercise['sets'] as $set) {
                $volume += (float)($set['weight'] ?? 0) * (int)($set['reps'] ?? 0);
            }
        }
        $this->totalVolume = $volume;
    }

    public function finishSession()
    {
        if (empty($this->exercises)) {
            $this->cancelSession();
            return;
        }

        $this->calculateVolume();

        WorkoutSession::create([
            'user_id' => Auth::id(),
            'type' => $this->trainingType,
            'exercises' => $this->exercises,
            'start_time' => $this->startTime,
            'end_time' => now(),
            'total_volume' => $this->totalVolume,
            'status' => 'completed'
        ]);

        $this->reset(['isSessionActive', 'trainingType', 'exercises', 'totalVolume']);
        session()->flash('success', 'Strength Vault Updated!');
    }

    public function cancelSession()
    {
        $this->reset(['isSessionActive', 'trainingType', 'exercises', 'totalVolume']);
    }

    public function render()
    {
        return view('livewire.active-workout');
    }
}
