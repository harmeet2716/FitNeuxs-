<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FitnessProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'goal',
        'gender',
        'age',
        'weight_kg',
        'height_cm',
        'activity_level',
        'days_per_week',
        'motivation',
        'source',
        'bmi',
        'body_fat_percent',
        'lean_mass_kg',
        'bmr',
        'tdee',
        'target_calories',
        'protein_g',
        'carbs_g',
        'fats_g',
    ];

    protected $casts = [
        'weight_kg'        => 'float',
        'height_cm'        => 'float',
        'bmi'              => 'float',
        'body_fat_percent' => 'float',
        'lean_mass_kg'     => 'float',
        'days_per_week'    => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ── Computed helpers used in the Blade view ──────────────────────────

    public function getBmiCategoryAttribute(): string
    {
        return match (true) {
            $this->bmi < 18.5 => 'Underweight',
            $this->bmi < 25   => 'Healthy',
            $this->bmi < 30   => 'Overweight',
            default           => 'Obese',
        };
    }

    public function getBmiBadgeAttribute(): string
    {
        return match (true) {
            $this->bmi < 18.5 => 'badge-low',
            $this->bmi < 25   => 'badge-ok',
            $this->bmi < 30   => 'badge-hi',
            default           => 'badge-vhi',
        };
    }

    public function getBodyFatCategoryAttribute(): string
    {
        [$lo, $hi] = $this->gender === 'male' ? [10, 20] : [18, 28];

        return match (true) {
            $this->body_fat_percent < $lo        => 'Low',
            $this->body_fat_percent <= $hi       => 'Healthy',
            $this->body_fat_percent <= $hi + 10  => 'Above avg',
            default                              => 'High',
        };
    }

    public function getBodyFatBadgeAttribute(): string
    {
        [$lo, $hi] = $this->gender === 'male' ? [10, 20] : [18, 28];

        return match (true) {
            $this->body_fat_percent < $lo        => 'badge-low',
            $this->body_fat_percent <= $hi       => 'badge-ok',
            $this->body_fat_percent <= $hi + 10  => 'badge-hi',
            default                              => 'badge-vhi',
        };
    }

    public function getGoalLabelAttribute(): string
    {
        return match ($this->goal) {
            'fat_loss'    => 'Fat Loss',
            'muscle_gain' => 'Muscle Gain',
            'strength'    => 'Strength',
            'endurance'   => 'Endurance',
            default       => ucfirst($this->goal),
        };
    }
}
