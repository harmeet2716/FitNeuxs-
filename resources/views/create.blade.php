{{-- resources/views/fitness/create.blade.php --}}
<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Fitness Profile</h2>
</x-slot>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700&display=swap');

    :root {
        --bg: #f7f7f5;
        --surface: #ffffff;
        --border: #e4e4e0;
        --text: #111111;
        --muted: #888880;
        --accent-light: #f0f0ec;
        --radius: 10px;
        --radius-lg: 14px;
    }

    .fw-wrap {
        font-family: 'Inter', ui-sans-serif, sans-serif;
        max-width: 600px;
        margin: 0 auto;
        padding: 2.5rem 1rem 4rem;
    }

    .fw-header { text-align: center; margin-bottom: 2.5rem; }

    .fw-brand {
        font-family: 'Sora', sans-serif;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--text);
    }

    .fw-tagline { font-size: 12px; color: var(--muted); margin-top: 6px; }

    /* Progress bar */
    .progress-wrap { display: flex; align-items: center; gap: 8px; margin-bottom: 2rem; }
    .prog-seg { flex: 1; height: 2px; background: var(--border); border-radius: 99px; transition: background 0.4s; }
    .prog-seg.active { background: var(--text); }
    .prog-seg.done { background: var(--text); opacity: 0.3; }
    .prog-label { font-size: 11px; color: var(--muted); white-space: nowrap; }

    /* Step cards */
    .step-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 2.25rem 2.25rem 1.75rem;
        display: none;
        animation: rise 0.3s ease forwards;
    }
    .step-card.active { display: block; }

    @keyframes rise {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .step-eyebrow {
        font-size: 10px; font-weight: 600; letter-spacing: 2px;
        text-transform: uppercase; color: var(--muted); margin-bottom: 10px;
    }

    .step-title {
        font-family: 'Sora', sans-serif;
        font-size: 20px; font-weight: 700; color: var(--text);
        margin-bottom: 6px; line-height: 1.35;
    }

    .step-desc { font-size: 13px; color: var(--muted); margin-bottom: 1.75rem; line-height: 1.65; }

    /* MCQ grid */
    .mcq-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 1.75rem; }
    .mcq-grid.cols-1 { grid-template-columns: 1fr; }

    .mcq-option {
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 14px 16px;
        cursor: pointer;
        transition: border-color 0.18s, background 0.18s;
        position: relative;
        user-select: none;
    }

    .mcq-option:hover { border-color: #aaa; background: var(--accent-light); }
    .mcq-option.selected { border-color: var(--text); background: var(--accent-light); }
    .mcq-option.selected::after {
        content: '';
        position: absolute; top: 12px; right: 14px;
        width: 8px; height: 8px;
        border-radius: 50%; background: var(--text);
    }

    .mcq-label { font-size: 13px; font-weight: 500; color: var(--text); margin-bottom: 3px; }
    .mcq-hint  { font-size: 11px; color: var(--muted); line-height: 1.5; }

    /* Inputs */
    .unit-toggle { display: flex; gap: 6px; margin-bottom: 1.25rem; }
    .unit-btn {
        border: 1px solid var(--border); background: transparent;
        border-radius: 6px; padding: 5px 14px;
        font-size: 12px; color: var(--muted); cursor: pointer; transition: all 0.18s;
    }
    .unit-btn.active { background: var(--text); border-color: var(--text); color: #fff; }

    .input-row { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; margin-bottom: 1.75rem; }
    .input-group { display: flex; flex-direction: column; gap: 6px; }
    .input-group label {
        font-size: 11px; font-weight: 500; color: var(--muted);
        letter-spacing: 0.5px; text-transform: uppercase;
    }
    .input-group input {
        border: 1px solid var(--border); border-radius: var(--radius);
        padding: 10px 12px; font-size: 14px;
        background: var(--surface); color: var(--text);
        transition: border-color 0.18s; width: 100%;
    }
    .input-group input:focus { outline: none; border-color: var(--text); }

    /* Footer */
    .step-footer {
        display: flex; align-items: center; justify-content: space-between;
        border-top: 1px solid var(--border); padding-top: 1.25rem; margin-top: 0.25rem;
    }

    .btn-back {
        font-size: 13px; color: var(--muted); background: none; border: none;
        cursor: pointer; padding: 8px 0; transition: color 0.18s;
    }
    .btn-back:hover { color: var(--text); }

    .btn-next {
        background: var(--text); color: #fff; border: none;
        border-radius: var(--radius); padding: 10px 22px;
        font-size: 13px; font-weight: 500; cursor: pointer; letter-spacing: 0.3px;
        transition: opacity 0.18s, transform 0.1s;
    }
    .btn-next:disabled { opacity: 0.25; cursor: not-allowed; }
    .btn-next:not(:disabled):hover { opacity: 0.82; }
    .btn-next:not(:disabled):active { transform: scale(0.97); }

    /* Validation errors */
    .error-box {
        background: #fee2e2; border: 1px solid #fca5a5;
        border-radius: var(--radius); padding: 12px 16px;
        font-size: 12px; color: #991b1b; margin-bottom: 1.5rem;
        line-height: 1.6;
    }
</style>

<div class="fw-wrap">

    <div class="fw-header">
        <div class="fw-brand">Fitform</div>
        <div class="fw-tagline">Your personalised fitness profile — 5 quick steps</div>
    </div>

    {{-- Progress bar --}}
    <div class="progress-wrap">
        @for ($i = 1; $i <= 5; $i++)
            <div class="prog-seg" id="dot-{{ $i }}"></div>
        @endfor
        <span class="prog-label" id="prog-label">1 / 5</span>
    </div>

    {{-- Validation errors --}}
    @if ($errors->any())
        <div class="error-box">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('fitness.store') }}" id="fitness-form">
        @csrf

        {{-- Hidden fields populated by JS --}}
        <input type="hidden" name="goal"            id="f-goal">
        <input type="hidden" name="gender"          id="f-gender">
        <input type="hidden" name="activity_level"  id="f-activity">
        <input type="hidden" name="experience"      id="f-experience">
        <input type="hidden" name="motivation"      id="f-motivation">

        {{-- STEP 1 — Goal --}}
        <div class="step-card" id="step-1">
            <div class="step-eyebrow">Step 1 of 5</div>
            <div class="step-title">What is your primary goal?</div>
            <div class="step-desc">We will tailor your entire profile around this. Choose what matters most right now.</div>
            <div class="mcq-grid" id="goal-grid">
                <div class="mcq-option" data-val="fat_loss"    onclick="pick(this,'goal')">
                    <div class="mcq-label">Fat Loss</div>
                    <div class="mcq-hint">Reduce body fat and improve body composition</div>
                </div>
                <div class="mcq-option" data-val="muscle_gain" onclick="pick(this,'goal')">
                    <div class="mcq-label">Muscle Gain</div>
                    <div class="mcq-hint">Build lean muscle mass and increase size</div>
                </div>
                <div class="mcq-option" data-val="strength"    onclick="pick(this,'goal')">
                    <div class="mcq-label">Strength</div>
                    <div class="mcq-hint">Increase raw power and functional strength</div>
                </div>
                <div class="mcq-option" data-val="endurance"   onclick="pick(this,'goal')">
                    <div class="mcq-label">Endurance</div>
                    <div class="mcq-hint">Improve stamina, cardio, and aerobic fitness</div>
                </div>
            </div>
            <div class="step-footer">
                <span></span>
                <button type="button" class="btn-next" id="next-1" disabled onclick="go(2)">Continue &rarr;</button>
            </div>
        </div>

        {{-- STEP 2 — Body Info --}}
        <div class="step-card" id="step-2">
            <div class="step-eyebrow">Step 2 of 5</div>
            <div class="step-title">Tell us about your body</div>
            <div class="step-desc">Used to calculate your BMI, body fat estimate, and daily calorie targets.</div>
            <div class="mcq-grid" id="gender-grid" style="margin-bottom:1rem;">
                <div class="mcq-option" data-val="male"   onclick="pick(this,'gender')">
                    <div class="mcq-label">Male</div>
                </div>
                <div class="mcq-option" data-val="female" onclick="pick(this,'gender')">
                    <div class="mcq-label">Female</div>
                </div>
            </div>
            <div class="unit-toggle">
                <button type="button" class="unit-btn active" onclick="setUnit('metric')">Metric (kg / cm)</button>
                <button type="button" class="unit-btn"        onclick="setUnit('imperial')">Imperial (lb / in)</button>
            </div>
            <div class="input-row">
                <div class="input-group">
                    <label id="lbl-age">Age (years)</label>
                    <input type="number" id="inp-age"    name="age"       placeholder="e.g. 28"  min="10" max="99" oninput="validateStep2()">
                </div>
                <div class="input-group">
                    <label id="lbl-weight">Weight (kg)</label>
                    <input type="number" id="inp-weight" name="weight_kg" placeholder="e.g. 75"  step="0.1" oninput="validateStep2()">
                </div>
                <div class="input-group">
                    <label id="lbl-height">Height (cm)</label>
                    <input type="number" id="inp-height" name="height_cm" placeholder="e.g. 175" step="0.1" oninput="validateStep2()">
                </div>
            </div>
            <div class="step-footer">
                <button type="button" class="btn-back" onclick="go(1)">&larr; Back</button>
                <button type="button" class="btn-next" id="next-2" disabled onclick="go(3)">Continue &rarr;</button>
            </div>
        </div>

        {{-- STEP 3 — Activity --}}
        <div class="step-card" id="step-3">
            <div class="step-eyebrow">Step 3 of 5</div>
            <div class="step-title">How active are you currently?</div>
            <div class="step-desc">Be honest — this significantly affects your calorie and macro calculations.</div>
            <div class="mcq-grid cols-1" id="activity-grid">
                <div class="mcq-option" data-val="sedentary"         onclick="pick(this,'activity')">
                    <div class="mcq-label">Sedentary</div>
                    <div class="mcq-hint">Little or no exercise, desk job</div>
                </div>
                <div class="mcq-option" data-val="lightly_active"    onclick="pick(this,'activity')">
                    <div class="mcq-label">Lightly Active</div>
                    <div class="mcq-hint">Light exercise 1–3 days / week</div>
                </div>
                <div class="mcq-option" data-val="moderately_active" onclick="pick(this,'activity')">
                    <div class="mcq-label">Moderately Active</div>
                    <div class="mcq-hint">Moderate exercise 3–5 days / week</div>
                </div>
                <div class="mcq-option" data-val="very_active"       onclick="pick(this,'activity')">
                    <div class="mcq-label">Very Active</div>
                    <div class="mcq-hint">Hard exercise 6–7 days / week</div>
                </div>
                <div class="mcq-option" data-val="athlete"           onclick="pick(this,'activity')">
                    <div class="mcq-label">Athlete</div>
                    <div class="mcq-hint">Very hard training or physical job, twice-daily sessions</div>
                </div>
            </div>
            <div class="step-footer">
                <button type="button" class="btn-back" onclick="go(2)">&larr; Back</button>
                <button type="button" class="btn-next" id="next-3" disabled onclick="go(4)">Continue &rarr;</button>
            </div>
        </div>

        {{-- STEP 4 — Experience --}}
        <div class="step-card" id="step-4">
            <div class="step-eyebrow">Step 4 of 5</div>
            <div class="step-title">What is your training experience?</div>
            <div class="step-desc">This calibrates difficulty, recovery time, and progression speed.</div>
            <div class="mcq-grid" id="experience-grid">
                <div class="mcq-option" data-val="beginner"     onclick="pick(this,'experience')">
                    <div class="mcq-label">Beginner</div>
                    <div class="mcq-hint">Less than 1 year of consistent training</div>
                </div>
                <div class="mcq-option" data-val="intermediate" onclick="pick(this,'experience')">
                    <div class="mcq-label">Intermediate</div>
                    <div class="mcq-hint">1–3 years with a solid base</div>
                </div>
                <div class="mcq-option" data-val="advanced"     onclick="pick(this,'experience')">
                    <div class="mcq-label">Advanced</div>
                    <div class="mcq-hint">3+ years, near genetic potential</div>
                </div>
                <div class="mcq-option" data-val="returning"    onclick="pick(this,'experience')">
                    <div class="mcq-label">Returning</div>
                    <div class="mcq-hint">Previously trained, picking it back up</div>
                </div>
            </div>
            <div class="step-footer">
                <button type="button" class="btn-back" onclick="go(3)">&larr; Back</button>
                <button type="button" class="btn-next" id="next-4" disabled onclick="go(5)">Continue &rarr;</button>
            </div>
        </div>

        {{-- STEP 5 — Motivation --}}
        <div class="step-card" id="step-5">
            <div class="step-eyebrow">Step 5 of 5</div>
            <div class="step-title">What is driving you?</div>
            <div class="step-desc">Understanding your "why" keeps motivation high when things get tough.</div>
            <div class="mcq-grid" id="motivation-grid">
                <div class="mcq-option" data-val="health"       onclick="pick(this,'motivation')">
                    <div class="mcq-label">Long-term Health</div>
                    <div class="mcq-hint">I want to live longer and feel better</div>
                </div>
                <div class="mcq-option" data-val="looks"        onclick="pick(this,'motivation')">
                    <div class="mcq-label">Aesthetics</div>
                    <div class="mcq-hint">I want to look better and feel confident</div>
                </div>
                <div class="mcq-option" data-val="performance"  onclick="pick(this,'motivation')">
                    <div class="mcq-label">Performance</div>
                    <div class="mcq-hint">I have a sport or event to train for</div>
                </div>
                <div class="mcq-option" data-val="mental"       onclick="pick(this,'motivation')">
                    <div class="mcq-label">Mental Wellbeing</div>
                    <div class="mcq-hint">Exercise helps my mood and mental health</div>
                </div>
            </div>
            <div class="step-footer">
                <button type="button" class="btn-back" onclick="go(4)">&larr; Back</button>
                <button type="submit" class="btn-next" id="btn-submit" disabled>View My Profile &rarr;</button>
            </div>
        </div>

    </form>
</div>

<script>
const state = { goal: null, gender: null, activity: null, experience: null, motivation: null, unit: 'metric' };
const hiddenMap = { goal: 'f-goal', gender: 'f-gender', activity: 'f-activity', experience: 'f-experience', motivation: 'f-motivation' };
const nextMap   = { goal: 'next-1', activity: 'next-3', experience: 'next-4', motivation: 'btn-submit' };

function pick(el, field) {
    el.parentNode.querySelectorAll('.mcq-option').forEach(o => o.classList.remove('selected'));
    el.classList.add('selected');
    state[field] = el.dataset.val;
    document.getElementById(hiddenMap[field]).value = el.dataset.val;
    if (nextMap[field]) document.getElementById(nextMap[field]).disabled = false;
    if (field === 'gender') validateStep2();
}

function setUnit(u) {
    state.unit = u;
    document.querySelectorAll('.unit-btn').forEach(b => b.classList.toggle('active', b.textContent.toLowerCase().includes(u === 'metric' ? 'metric' : 'imperial')));
    document.getElementById('lbl-weight').textContent = u === 'metric' ? 'Weight (kg)' : 'Weight (lb)';
    document.getElementById('lbl-height').textContent = u === 'metric' ? 'Height (cm)' : 'Height (in)';
    document.getElementById('inp-weight').placeholder  = u === 'metric' ? 'e.g. 75'  : 'e.g. 165';
    document.getElementById('inp-height').placeholder  = u === 'metric' ? 'e.g. 175' : 'e.g. 69';
    validateStep2();
}

function validateStep2() {
    const a = document.getElementById('inp-age').value;
    const w = document.getElementById('inp-weight').value;
    const h = document.getElementById('inp-height').value;

    // Convert imperial to metric before submitting
    if (state.unit === 'imperial' && w && h) {
        document.getElementById('inp-weight').setAttribute('data-metric', (parseFloat(w) * 0.453592).toFixed(2));
        document.getElementById('inp-height').setAttribute('data-metric', (parseFloat(h) * 2.54).toFixed(2));
    }

    document.getElementById('next-2').disabled = !(a && w && h && state.gender);
}

// Convert imperial values to metric on form submit (server expects kg/cm)
document.getElementById('fitness-form').addEventListener('submit', function () {
    if (state.unit === 'imperial') {
        const wEl = document.getElementById('inp-weight');
        const hEl = document.getElementById('inp-height');
        wEl.value = (parseFloat(wEl.value) * 0.453592).toFixed(2);
        hEl.value = (parseFloat(hEl.value) * 2.54).toFixed(2);
    }
});

function go(n) {
    document.querySelectorAll('.step-card').forEach(c => c.classList.remove('active'));
    document.getElementById('step-' + n).classList.add('active');
    for (let i = 1; i <= 5; i++) {
        const d = document.getElementById('dot-' + i);
        d.className = 'prog-seg' + (i < n ? ' done' : i === n ? ' active' : '');
    }
    document.getElementById('prog-label').textContent = n + ' / 5';
}

// Init — show step 1
go(1);
</script>

</x-app-layout>
