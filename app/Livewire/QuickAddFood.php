<?php

namespace App\Livewire;

use App\Models\DailyLog;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class QuickAddFood extends Component
{
    public $foodName = '';
    public $calories = '';
    public $protein = '';
    public $carbs = '';
    public $fats = '';
    public $currentMealType = 'Morning';
    
    // Calibration State
    public $showCalibrationModal = false;
    public $amount = 100;
    public $unit = 'g';
    public $baseMacros = [
        'kcal' => 0,
        'p' => 0,
        'c' => 0,
        'f' => 0
    ];

    public $searchResults = [];
    public $showDropdown = false;

    public function rules()
    {
        return [
            'foodName' => 'required|string|max:255',
            'calories' => 'required|numeric|min:0',
            'protein' => 'required|numeric|min:0',
            'carbs' => 'required|numeric|min:0',
            'fats' => 'required|numeric|min:0',
            'currentMealType' => 'required|in:Morning,Lunch,Snacks,Dinner',
            'amount' => 'required|numeric|min:1',
            'unit' => 'required|in:g,ml,oz,servings',
        ];
    }

    public function setMealType($type)
    {
        $this->currentMealType = $type;
    }

    public function updatedFoodName($value)
    {
        if (strlen($value) < 3) {
            $this->searchResults = [];
            $this->showDropdown = false;
            return;
        }

        $this->searchResults = $this->fetchFromAPI($value);
        $this->showDropdown = count($this->searchResults) > 0;
    }

    private function fetchFromAPI($query)
    {
        $apiKey = env('USDA_API_KEY', 'DEMO_KEY');

        try {
            $response = \Illuminate\Support\Facades\Http::get('https://api.nal.usda.gov/fdc/v1/foods/search', [
                'query' => $query,
                'api_key' => $apiKey,
                'pageSize' => 5,
                'dataType' => ['Foundation', 'Branded', 'SR Legacy'],
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return collect($data['foods'] ?? [])->map(function($food) {
                    $nutrients = collect($food['foodNutrients'] ?? []);
                    
                    return [
                        'fdcId' => (string) ($food['fdcId'] ?? null),
                        'name' => ucfirst(strtolower($food['description'])),
                        'brand' => $food['brandOwner'] ?? null,
                        'kcal' => $this->getNutrientValue($nutrients, [1008, 2047, 2048]),
                        'p' => $this->getNutrientValue($nutrients, [1003]),
                        'c' => $this->getNutrientValue($nutrients, [1005]),
                        'f' => $this->getNutrientValue($nutrients, [1004]),
                        'is_api' => true
                    ];
                })->toArray();
            }
        } catch (\Exception $e) {
            return $this->getMockData($query);
        }

        return $this->getMockData($query);
    }

    private function getNutrientValue($nutrients, $ids)
    {
        $nutrient = $nutrients->first(function($n) use ($ids) {
            return in_array($n['nutrientId'] ?? $n['attrId'] ?? 0, $ids);
        });

        return $nutrient ? ($nutrient['value'] ?? $nutrient['amount'] ?? 0) : 0;
    }

    private function getMockData($query)
    {
        $mockData = [
            'chicken' => [['fdcId' => 'mock-1', 'name' => 'Chicken Breast (Grilled)', 'kcal' => 165, 'p' => 31, 'c' => 0, 'f' => 3.6]],
            'paneer' => [['fdcId' => 'mock-2', 'name' => 'Paneer (Cottage Cheese)', 'kcal' => 265, 'p' => 18, 'c' => 1, 'f' => 20]],
            'rajma' => [['fdcId' => 'mock-3', 'name' => 'Rajma (Kidney Beans)', 'kcal' => 333, 'p' => 24, 'c' => 60, 'f' => 0.8]],
            'egg' => [['fdcId' => 'mock-4', 'name' => 'Egg (Large Boiled)', 'kcal' => 78, 'p' => 6, 'c' => 0.6, 'f' => 5]],
            'rice' => [['fdcId' => 'mock-5', 'name' => 'White Rice (Cooked)', 'kcal' => 130, 'p' => 2.7, 'c' => 28, 'f' => 0.3]],
        ];

        foreach ($mockData as $key => $results) {
            if (str_contains(strtolower($query), $key)) {
                return $results;
            }
        }
        return [];
    }

    public function selectFood($fdcId)
    {
        $selected = collect($this->searchResults)->first(function($item) use ($fdcId) {
            return (string) $item['fdcId'] === (string) $fdcId;
        });
        
        if (!$selected) return;

        $this->foodName = $selected['name'];
        
        // Store Base Macros (usually per 100g/ml)
        $this->baseMacros = [
            'kcal' => $selected['kcal'],
            'p' => $selected['p'],
            'c' => $selected['c'],
            'f' => $selected['f']
        ];

        $this->amount = 100; // Default calibration start
        $this->unit = 'g';
        $this->updateScaledValues();

        $this->showDropdown = false;
        $this->searchResults = [];
        $this->showCalibrationModal = true;
    }

    public function updatedAmount()
    {
        $this->updateScaledValues();
    }

    public function updatedUnit()
    {
        $this->updateScaledValues();
    }

    private function updateScaledValues()
    {
        $multiplier = (float)$this->amount / 100;
        
        $this->calories = round($this->baseMacros['kcal'] * $multiplier, 1);
        $this->protein = round($this->baseMacros['p'] * $multiplier, 1);
        $this->carbs = round($this->baseMacros['c'] * $multiplier, 1);
        $this->fats = round($this->baseMacros['f'] * $multiplier, 1);
    }

    public function saveFood()
    {
        $this->validate();

        $user = Auth::user();
        $date = now()->toDateString();
        
        $log = DailyLog::updateOrCreate(
            ['user_id' => $user->id, 'date' => $date],
            []
        );

        $meals = $log->meals ?? [];
        $meals[] = [
            'id' => uniqid(),
            'name' => $this->foodName,
            'quantity' => (float)$this->amount,
            'unit' => $this->unit,
            'meal_type' => $this->currentMealType,
            'calories' => (float) $this->calories,
            'protein' => (float) $this->protein,
            'carbs' => (float) $this->carbs,
            'fats' => (float) $this->fats,
            'synced_at' => now()->toDateTimeString(),
        ];

        $log->update(['meals' => $meals]);

        $this->reset(['foodName', 'calories', 'protein', 'carbs', 'fats', 'showCalibrationModal', 'amount']);
        session()->flash('success', 'Metabolic Payload Synced!');
    }

    public function deleteFood($id)
    {
        $user = Auth::user();
        $log = DailyLog::where('user_id', $user->id)
                       ->where('date', now()->toDateString())
                       ->first();

        if ($log && is_array($log->meals)) {
            $meals = collect($log->meals)->reject(function($meal) use ($id) {
                return ($meal['id'] ?? null) === $id;
            })->values()->toArray();

            $log->update(['meals' => $meals]);
        }
    }

    public function render()
    {
        $user = Auth::user();
        $profile = $user->fitnessProfile;
        
        $targetCalories = $profile->target_calories ?? 2000;
        $targetProtein = $profile->protein_g ?? 150;
        $targetCarbs = $profile->carbs_g ?? 200;
        $targetFats = $profile->fats_g ?? 70;
        
        $log = DailyLog::where('user_id', $user->id)
                       ->where('date', 'like', now()->toDateString() . '%')
                       ->first();
        
        $consumedCalories = 0;
        $consumedProtein = 0;
        $consumedCarbs = 0;
        $consumedFats = 0;
        $meals = [];
        
        if ($log && is_array($log->meals)) {
            $meals = $log->meals;
            $consumedCalories = collect($meals)->sum('calories');
            $consumedProtein = collect($meals)->sum('protein');
            $consumedCarbs = collect($meals)->sum('carbs');
            $consumedFats = collect($meals)->sum('fats');
        }
        
        $caloriesRemaining = max(0, $targetCalories - $consumedCalories);

        return view('livewire.quick-add-food', [
            'consumedCalories' => $consumedCalories,
            'consumedProtein' => $consumedProtein,
            'consumedCarbs' => $consumedCarbs,
            'consumedFats' => $consumedFats,
            'caloriesRemaining' => $caloriesRemaining,
            'targetCalories' => $targetCalories,
            'targetProtein' => $targetProtein,
            'targetCarbs' => $targetCarbs,
            'targetFats' => $targetFats,
            'meals' => $meals
        ]);
    }
}
