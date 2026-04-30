{{-- resources/views/fitness/show.blade.php --}}
<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Your Fitness Profile</h2>
</x-slot>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700&display=swap');

    :root {
        --bg: #f7f7f5;
        --surface: #ffffff;
        --border: #e4e4e0;
        --text: #111111;
        --muted: #888880;
        --radius: 10px;
        --radius-lg: 14px;
    }

    .res-wrap {
        font-family: 'Inter', ui-sans-serif, sans-serif;
        max-width: 600px;
        margin: 0 auto;
        padding: 2.5rem 1rem 4rem;
    }

    .res-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 2.25rem;
        animation: rise 0.4s ease forwards;
    }

    @keyframes rise {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .res-header { border-bottom: 1px solid var(--border); padding-bottom: 1.25rem; margin-bottom: 1.5rem; }
    .res-title  { font-family: 'Sora', sans-serif; font-size: 20px; font-weight: 700; color: var(--text); margin-bottom: 4px; }
    .res-meta   { font-size: 12px; color: var(--muted); }

    /* Metric tiles */
    .metrics-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 1.25rem; }

    .metric-tile {
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 16px 18px;
    }

    .metric-label { font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; color: var(--muted); margin-bottom: 8px; }
    .metric-top   { display: flex; align-items: flex-end; gap: 4px; margin-bottom: 6px; }
    .metric-value { font-family: 'Sora', sans-serif; font-size: 26px; font-weight: 700; color: var(--text); line-height: 1; }
    .metric-unit  { font-size: 12px; color: var(--muted); margin-bottom: 2px; }

    .badge {
        display: inline-block; padding: 3px 9px;
        border-radius: 4px; font-size: 10px;
        font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase;
    }
    .badge-ok  { background: #eaf4ef; color: #2d6a4f; }
    .badge-low { background: #dbeafe; color: #1e40af; }
    .badge-hi  { background: #fef3c7; color: #92400e; }
    .badge-vhi { background: #fee2e2; color: #991b1b; }

    /* Macro table */
    .macro-section { border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; margin-bottom: 1.25rem; }
    .macro-header  { background: var(--bg); padding: 12px 16px; font-size: 10px; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase; color: var(--muted); border-bottom: 1px solid var(--border); }
    .macro-row     { display: flex; justify-content: space-between; align-items: center; padding: 11px 16px; font-size: 13px; border-bottom: 1px solid var(--border); }
    .macro-row:last-child { border-bottom: none; }
    .macro-name    { color: var(--muted); }
    .macro-val     { font-weight: 500; color: var(--text); }

    .bar-track { height: 2px; background: var(--border); border-radius: 99px; margin: 4px 16px 14px; overflow: hidden; }
    .bar-fill  { height: 100%; background: var(--text); border-radius: 99px; }

    /* Insights */
    .insight { display: flex; gap: 14px; padding: 14px 0; border-top: 1px solid var(--border); }
    .insight-line { width: 2px; background: var(--border); border-radius: 99px; flex-shrink: 0; }
    .insight-title { font-size: 12px; font-weight: 600; color: var(--text); margin-bottom: 4px; }
    .insight-text  { font-size: 12px; color: var(--muted); line-height: 1.6; }

    .btn-redo {
        display: block; width: 100%; margin-top: 1.5rem;
        background: transparent; border: 1px solid var(--border);
        border-radius: var(--radius); padding: 10px;
        font-size: 12px; font-weight: 500; color: var(--muted);
        text-align: center; text-decoration: none;
        transition: all 0.18s;
    }
    .btn-redo:hover { border-color: var(--text); color: var(--text); }
</style>

<div class="res-wrap">

    @if (session('success'))
        <div style="background:#eaf4ef;border:1px solid #bbf7d0;border-radius:10px;padding:12px 16px;font-size:12px;color:#2d6a4f;margin-bottom:1.5rem;">
            Profile saved successfully.
        </div>
    @endif

    <div class="res-card">

        <div class="res-header">
            <div class="res-title">Body Profile</div>
            <div class="res-meta">
                Goal: <strong>{{ $profile->goal_label }}</strong>
                &nbsp;&middot;&nbsp;
                {{ ucfirst($profile->experience) }}
                &nbsp;&middot;&nbsp;
                {{ ucfirst(str_replace('_', ' ', $profile->activity_level)) }}
            </div>
        </div>

        {{-- Metric tiles --}}
        <div class="metrics-grid">

            <div class="metric-tile">
                <div class="metric-label">BMI</div>
                <div class="metric-top">
                    <div class="metric-value">{{ number_format($profile->bmi, 1) }}</div>
                    <div class="metric-unit">kg/m&sup2;</div>
                </div>
                <span class="badge {{ $profile->bmi_badge }}">{{ $profile->bmi_category }}</span>
            </div>

            <div class="metric-tile">
                <div class="metric-label">Est. Body Fat</div>
                <div class="metric-top">
                    <div class="metric-value">{{ number_format($profile->body_fat_percent, 1) }}</div>
                    <div class="metric-unit">%</div>
                </div>
                <span class="badge {{ $profile->body_fat_badge }}">{{ $profile->body_fat_category }}</span>
            </div>

            <div class="metric-tile">
                <div class="metric-label">Lean Mass</div>
                <div class="metric-top">
                    <div class="metric-value">{{ number_format($profile->lean_mass_kg, 1) }}</div>
                    <div class="metric-unit">kg</div>
                </div>
                <span class="badge badge-ok">Estimated</span>
            </div>

            <div class="metric-tile">
                <div class="metric-label">TDEE</div>
                <div class="metric-top">
                    <div class="metric-value">{{ number_format($profile->tdee) }}</div>
                    <div class="metric-unit">kcal</div>
                </div>
                <span class="badge badge-ok">Maintenance</span>
            </div>

        </div>

        {{-- Macros --}}
        <div class="macro-section">
            <div class="macro-header">Daily Targets</div>
            <div class="macro-row">
                <span class="macro-name">Recommended calories</span>
                <span class="macro-val">{{ number_format($profile->target_calories) }} kcal</span>
            </div>
            <div class="macro-row">
                <span class="macro-name">Protein</span>
                <span class="macro-val">{{ $profile->protein_g }} g</span>
            </div>
            <div class="macro-row">
                <span class="macro-name">Carbohydrates</span>
                <span class="macro-val">{{ $profile->carbs_g }} g</span>
            </div>
            <div class="macro-row">
                <span class="macro-name">Fats</span>
                <span class="macro-val">{{ $profile->fats_g }} g</span>
            </div>
            @php
                $barPct = min(100, round(($profile->target_calories / ($profile->tdee * 1.3)) * 100));
            @endphp
            <div class="bar-track">
                <div class="bar-fill" style="width: {{ $barPct }}%"></div>
            </div>
        </div>

        {{-- Insights --}}
        @php
            $insights = [];

            if ($profile->bmi > 25) {
                $insights[] = ['title' => 'BMI above optimal range', 'text' => 'A gradual calorie deficit of 300–400 kcal per day is safer and more sustainable than aggressive cuts.'];
            }

            $bfHi = $profile->gender === 'male' ? 20 : 28;
            if ($profile->body_fat_percent > $bfHi) {
                $insights[] = ['title' => 'Body fat above healthy range', 'text' => 'Prioritise compound lifts and a moderate deficit. Avoid over-restricting carbohydrates.'];
            }

            if ($profile->experience === 'beginner') {
                $insights[] = ['title' => 'Beginner advantage', 'text' => 'You can build muscle and lose fat simultaneously early on — a rare benefit for newcomers.'];
            }

            if ($profile->goal === 'muscle_gain') {
                $insights[] = ['title' => 'Muscle gain tip', 'text' => 'Hit ' . $profile->protein_g . 'g of protein daily and train each muscle group at least twice per week.'];
            }

            if ($profile->goal === 'fat_loss') {
                $insights[] = ['title' => 'Fat loss tip', 'text' => 'Your target of ' . number_format($profile->target_calories) . ' kcal creates a healthy deficit. Track weekly weigh-ins, not daily ones.'];
            }
        @endphp

        @foreach ($insights as $insight)
            <div class="insight">
                <div class="insight-line"></div>
                <div>
                    <div class="insight-title">{{ $insight['title'] }}</div>
                    <div class="insight-text">{{ $insight['text'] }}</div>
                </div>
            </div>
        @endforeach

        <a href="{{ route('fitness.create') }}" class="btn-redo">Update profile</a>

    </div>
</div>

</x-app-layout>
