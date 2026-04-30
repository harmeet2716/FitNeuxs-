<x-app-layout>
    <div class="min-h-screen bg-gray-950 text-white py-10 px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-4xl">
            <div class="rounded-[2rem] border border-gray-800 bg-gray-900/90 p-8 shadow-2xl shadow-black/30 backdrop-blur-xl sm:p-10">
                <div class="mb-10 text-center">
                    <p class="text-sm uppercase tracking-[0.32em] text-green-400">FitNexus onboarding</p>
                    <h1 class="mt-4 text-3xl font-semibold tracking-tight text-white sm:text-4xl">Build your fitness profile in 5 easy steps</h1>
                    <p class="mt-3 text-gray-400 max-w-2xl mx-auto">Share your goals, body info, and training habits so we can personalize your workout plan.</p>
                </div>

                <div class="mb-8 rounded-full bg-gray-800 p-1">
                    <div class="grid grid-cols-5 gap-2">
                        <span id="progress-1" class="h-2 rounded-full bg-green-400"></span>
                        <span id="progress-2" class="h-2 rounded-full bg-gray-700"></span>
                        <span id="progress-3" class="h-2 rounded-full bg-gray-700"></span>
                        <span id="progress-4" class="h-2 rounded-full bg-gray-700"></span>
                        <span id="progress-5" class="h-2 rounded-full bg-gray-700"></span>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="mb-8 rounded-3xl border border-red-500/70 bg-red-500/10 p-4 text-sm text-red-200">
                        <div class="font-semibold">Please fix the following</div>
                        <ul class="mt-3 list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('fitness.store') }}" id="onboarding-form" class="space-y-8">
                    @csrf

                    <input type="hidden" name="goal" id="goal-field">
                    <input type="hidden" name="gender" id="gender-field">
                    <input type="hidden" name="activity_level" id="activity-field">

                    <div class="step-card" id="step-1">
                        <div class="space-y-3">
                            <div class="text-sm uppercase tracking-[0.28em] text-gray-400">Step 1 of 5</div>
                            <h2 class="text-2xl font-semibold text-white">Choose your goal</h2>
                            <p class="text-gray-400">Personalized programming starts here. Pick the goal you want to achieve most.</p>
                        </div>

                        <div class="mt-8 grid gap-4 sm:grid-cols-3">
                            @foreach (['fat_loss' => 'Fat Loss', 'muscle_gain' => 'Muscle Gain', 'strength' => 'Strength'] as $value => $label)
                                <button type="button" class="option-card" data-value="{{ $value }}" data-field="goal" onclick="pickOption(this)">
                                    <span class="text-sm uppercase tracking-[0.24em] text-green-400">{{ $label }}</span>
                                    <span class="mt-3 block text-white text-xl font-semibold">{{ $label }}</span>
                                </button>
                            @endforeach
                        </div>

                        <div class="mt-8 flex items-center justify-between">
                            <span></span>
                            <button type="button" class="step-next disabled:opacity-40" id="step-1-next" disabled onclick="goStep(2)">Continue</button>
                        </div>
                    </div>

                    <div class="step-card hidden" id="step-2">
                        <div class="space-y-3">
                            <div class="text-sm uppercase tracking-[0.28em] text-gray-400">Step 2 of 5</div>
                            <h2 class="text-2xl font-semibold text-white">Tell us about your body</h2>
                            <p class="text-gray-400">This information helps calculate your baseline and daily needs.</p>
                        </div>

                        <div class="mt-8 grid gap-4 sm:grid-cols-2">
                            <button type="button" class="option-card" data-value="male" data-field="gender" onclick="pickOption(this)">
                                <span class="text-sm uppercase tracking-[0.24em] text-green-400">Male</span>
                                <span class="mt-3 block text-white text-xl font-semibold">Male</span>
                            </button>
                            <button type="button" class="option-card" data-value="female" data-field="gender" onclick="pickOption(this)">
                                <span class="text-sm uppercase tracking-[0.24em] text-green-400">Female</span>
                                <span class="mt-3 block text-white text-xl font-semibold">Female</span>
                            </button>
                        </div>

                        <div class="mt-8 flex flex-col gap-4 sm:flex-row">
                            <div class="flex flex-1 items-center gap-3 rounded-3xl border border-gray-800 bg-gray-950 p-4">
                                <button type="button" class="unit-button active" id="metric-btn" onclick="setUnit('metric')">kg / cm</button>
                                <button type="button" class="unit-button" id="imperial-btn" onclick="setUnit('imperial')">lb / ft in</button>
                            </div>
                        </div>

                        <div class="mt-8 grid gap-4 sm:grid-cols-3">
                            <label class="block">
                                <span class="text-sm font-medium text-gray-200">Age</span>
                                <input id="age-field" name="age" type="number" min="10" max="99" placeholder="28" class="mt-2 block w-full rounded-2xl border border-gray-800 bg-gray-950 px-4 py-3 text-white focus:border-green-400 focus:outline-none focus:ring-2 focus:ring-green-400/30" oninput="validateStep2()" />
                            </label>
                            <label class="block">
                                <span class="text-sm font-medium text-gray-200">Weight</span>
                                <input id="weight-field" type="number" min="20" max="900" step="0.1" placeholder="75" class="mt-2 block w-full rounded-2xl border border-gray-800 bg-gray-950 px-4 py-3 text-white focus:border-green-400 focus:outline-none focus:ring-2 focus:ring-green-400/30" oninput="validateStep2()" />
                                <div class="mt-2 text-xs text-gray-500" id="weight-unit-label">kg</div>
                            </label>
                            <div class="grid gap-4">
                                <div id="height-metric-group">
                                    <label class="block">
                                        <span class="text-sm font-medium text-gray-200">Height</span>
                                        <input id="height-field" type="number" min="50" max="250" step="0.1" placeholder="175" class="mt-2 block w-full rounded-2xl border border-gray-800 bg-gray-950 px-4 py-3 text-white focus:border-green-400 focus:outline-none focus:ring-2 focus:ring-green-400/30" oninput="validateStep2()" />
                                        <div class="mt-2 text-xs text-gray-500">cm</div>
                                    </label>
                                </div>
                                <div id="height-imperial-group" class="hidden">
                                    <label class="block">
                                        <span class="text-sm font-medium text-gray-200">Height</span>
                                        <div class="mt-2 grid gap-3 sm:grid-cols-2">
                                            <input id="height-ft-field" type="number" min="3" max="8" placeholder="5 ft" class="block w-full rounded-2xl border border-gray-800 bg-gray-950 px-4 py-3 text-white focus:border-green-400 focus:outline-none focus:ring-2 focus:ring-green-400/30" oninput="validateStep2()" />
                                            <input id="height-in-field" type="number" min="0" max="11" placeholder="9 in" class="block w-full rounded-2xl border border-gray-800 bg-gray-950 px-4 py-3 text-white focus:border-green-400 focus:outline-none focus:ring-2 focus:ring-green-400/30" oninput="validateStep2()" />
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex items-center justify-between">
                            <button type="button" class="text-sm font-semibold text-gray-400 hover:text-white" onclick="goStep(1)">Back</button>
                            <button type="button" class="step-next disabled:opacity-40" id="step-2-next" disabled onclick="goStep(3)">Continue</button>
                        </div>
                    </div>

                    <div class="step-card hidden" id="step-3">
                        <div class="space-y-3">
                            <div class="text-sm uppercase tracking-[0.28em] text-gray-400">Step 3 of 5</div>
                            <h2 class="text-2xl font-semibold text-white">Choose your training rhythm</h2>
                            <p class="text-gray-400">This helps us recommend the right intensity and weekly cadence.</p>
                        </div>

                        <div class="mt-8 grid gap-4 sm:grid-cols-3">
                            @foreach (['beginner' => 'Beginner', 'intermediate' => 'Intermediate', 'advanced' => 'Advanced'] as $value => $label)
                                <button type="button" class="option-card" data-value="{{ $value }}" data-field="activity_level" onclick="pickOption(this)">
                                    <span class="text-sm uppercase tracking-[0.24em] text-green-400">{{ $label }}</span>
                                    <span class="mt-3 block text-white text-xl font-semibold">{{ $label }}</span>
                                </button>
                            @endforeach
                        </div>

                        <div class="mt-8 grid gap-4 sm:grid-cols-2">
                            <label class="block">
                                <span class="text-sm font-medium text-gray-200">Workout days per week</span>
                                <input id="days-field" name="days_per_week" type="number" min="1" max="7" placeholder="4" class="mt-2 block w-full rounded-2xl border border-gray-800 bg-gray-950 px-4 py-3 text-white focus:border-green-400 focus:outline-none focus:ring-2 focus:ring-green-400/30" oninput="validateStep3()" />
                            </label>
                        </div>

                        <div class="mt-8 flex items-center justify-between">
                            <button type="button" class="text-sm font-semibold text-gray-400 hover:text-white" onclick="goStep(2)">Back</button>
                            <button type="button" class="step-next disabled:opacity-40" id="step-3-next" disabled onclick="goStep(4)">Continue</button>
                        </div>
                    </div>

                    <div class="step-card hidden" id="step-4">
                        <div class="space-y-3">
                            <div class="text-sm uppercase tracking-[0.28em] text-gray-400">Step 4 of 5</div>
                            <h2 class="text-2xl font-semibold text-white">What drives you?</h2>
                            <p class="text-gray-400">Choose the motivation that keeps you moving.</p>
                        </div>

                        <div class="mt-8 grid gap-4 sm:grid-cols-2">
                            @foreach (['health' => 'Health', 'looks' => 'Looks', 'performance' => 'Performance', 'mental' => 'Mental Wellbeing', 'other' => 'Other'] as $value => $label)
                                <button type="button" class="option-card" data-value="{{ $value }}" data-field="motivation" onclick="pickOption(this)">
                                    <span class="text-sm uppercase tracking-[0.24em] text-green-400">{{ $label }}</span>
                                    <span class="mt-3 block text-white text-xl font-semibold">{{ $label }}</span>
                                </button>
                            @endforeach
                        </div>

                        <div id="motivation-other-group" class="mt-6 hidden">
                            <label class="block">
                                <span class="text-sm font-medium text-gray-200">Please explain</span>
                                <textarea id="motivation-other-field" class="mt-2 block w-full rounded-3xl border border-gray-800 bg-gray-950 px-4 py-3 text-white focus:border-green-400 focus:outline-none focus:ring-2 focus:ring-green-400/30" rows="4" placeholder="Tell us your motivation" oninput="validateMotivationOther()"></textarea>
                            </label>
                        </div>

                        <input type="hidden" name="motivation" id="motivation-hidden">

                        <div class="mt-8 flex items-center justify-between">
                            <button type="button" class="text-sm font-semibold text-gray-400 hover:text-white" onclick="goStep(3)">Back</button>
                            <button type="button" class="step-next disabled:opacity-40" id="step-4-next" disabled onclick="goStep(5)">Continue</button>
                        </div>
                    </div>

                    <div class="step-card hidden" id="step-5">
                        <div class="space-y-3">
                            <div class="text-sm uppercase tracking-[0.28em] text-gray-400">Step 5 of 5</div>
                            <h2 class="text-2xl font-semibold text-white">Final step</h2>
                            <p class="text-gray-400">How did you hear about us?</p>
                        </div>

                        <div class="mt-8 grid gap-4 sm:grid-cols-2">
                            @foreach (['Friend' => 'Friend', 'Instagram' => 'Instagram', 'Search' => 'Search', 'Other' => 'Other'] as $value => $label)
                                <button type="button" class="option-card" data-value="{{ $value }}" data-field="source" onclick="pickOption(this)">
                                    <span class="text-sm uppercase tracking-[0.24em] text-green-400">{{ $label }}</span>
                                    <span class="mt-3 block text-white text-xl font-semibold">{{ $label }}</span>
                                </button>
                            @endforeach
                        </div>

                        <div id="source-other-group" class="mt-6 hidden">
                            <label class="block">
                                <span class="text-sm font-medium text-gray-200">Please specify</span>
                                <input id="source-other-field" type="text" class="mt-2 block w-full rounded-2xl border border-gray-800 bg-gray-950 px-4 py-3 text-white focus:border-green-400 focus:outline-none focus:ring-2 focus:ring-green-400/30" placeholder="Referral source" oninput="validateSourceOther()" />
                            </label>
                        </div>

                        <input type="hidden" name="source" id="source-hidden">

                        <div class="mt-8 flex items-center justify-between">
                            <button type="button" class="text-sm font-semibold text-gray-400 hover:text-white" onclick="goStep(4)">Back</button>
                            <button type="submit" class="step-next bg-green-400 text-gray-950 hover:bg-green-300" id="step-5-submit" disabled>Finish onboarding</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .step-card {
            animation: fadeIn 0.25s ease-out;
        }

        .option-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border: 1px solid rgba(148,163,184,.12);
            background: rgba(15,23,42,.9);
            border-radius: 1.5rem;
            padding: 1.5rem;
            text-align: left;
            transition: transform .2s ease, border-color .2s ease, background .2s ease;
            width: 100%;
        }

        .option-card:hover,
        .option-card.selected {
            border-color: rgba(34,197,94,.45);
            background: rgba(34,197,94,.08);
            transform: translateY(-3px);
        }

        .step-next {
            border-radius: 999px;
            padding: 0.85rem 1.75rem;
            background: #22c55e;
            color: #0f172a;
            font-weight: 700;
            transition: background .2s ease, transform .2s ease;
        }

        .step-next:hover {
            background: #4ade80;
        }

        .unit-button {
            flex: 1;
            border-radius: 999px;
            padding: 0.85rem 1rem;
            border: 1px solid rgba(148,163,184,.2);
            background: rgba(255,255,255,.04);
            color: #d1d5db;
            font-weight: 700;
            transition: background .2s ease, border-color .2s ease, color .2s ease;
        }

        .unit-button.active {
            background: #22c55e;
            color: #0f172a;
            border-color: rgba(34,197,94,.7);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <script>
        const state = {
            goal: null,
            gender: null,
            activity_level: null,
            motivation: null,
            source: null,
            unit: 'metric',
        };

        function pickOption(button) {
            const field = button.dataset.field;
            const value = button.dataset.value;

            document.querySelectorAll(`[data-field='${field}']`).forEach(el => el.classList.remove('selected'));
            button.classList.add('selected');

            state[field] = value;

            if (field === 'goal') {
                document.getElementById('goal-field').value = value;
                document.getElementById('step-1-next').disabled = false;
            }

            if (field === 'gender') {
                document.getElementById('gender-field').value = value;
                validateStep2();
            }

            if (field === 'activity_level') {
                document.getElementById('activity-field').value = value;
                validateStep3();
            }

            if (field === 'motivation') {
                if (value === 'other') {
                    document.getElementById('motivation-other-group').classList.remove('hidden');
                    document.getElementById('motivation-hidden').value = '';
                    state.motivation = null;
                    document.getElementById('step-4-next').disabled = true;
                } else {
                    document.getElementById('motivation-other-group').classList.add('hidden');
                    document.getElementById('motivation-hidden').value = value;
                    state.motivation = value;
                    document.getElementById('step-4-next').disabled = false;
                }
            }

            if (field === 'source') {
                document.getElementById('source-hidden').value = value;
                if (value === 'Other') {
                    document.getElementById('source-other-group').classList.remove('hidden');
                    document.getElementById('source-hidden').value = '';
                    state.source = null;
                    document.getElementById('step-5-submit').disabled = true;
                } else {
                    document.getElementById('source-other-group').classList.add('hidden');
                    document.getElementById('step-5-submit').disabled = false;
                    state.source = value;
                }
            }

            if (field === 'source' && value !== 'Other') {
                document.getElementById('source-hidden').value = value;
            }
        }

        function setUnit(unit) {
            state.unit = unit;
            document.getElementById('metric-btn').classList.toggle('active', unit === 'metric');
            document.getElementById('imperial-btn').classList.toggle('active', unit === 'imperial');
            document.getElementById('weight-unit-label').textContent = unit === 'metric' ? 'kg' : 'lb';
            document.getElementById('height-metric-group').classList.toggle('hidden', unit === 'imperial');
            document.getElementById('height-imperial-group').classList.toggle('hidden', unit === 'metric');
            validateStep2();
        }

        function validateStep2() {
            const age = Number(document.getElementById('age-field').value);
            const weight = Number(document.getElementById('weight-field').value);
            const isMetric = state.unit === 'metric';
            const heightMetric = Number(document.getElementById('height-field').value);
            const heightFt = Number(document.getElementById('height-ft-field').value);
            const heightIn = Number(document.getElementById('height-in-field').value);
            const hasGender = !!state.gender;

            let heightReady = false;
            let weightReady = weight > 0;
            let validHeight = 0;
            let validWeight = 0;

            if (isMetric) {
                heightReady = heightMetric > 0;
                validHeight = heightMetric;
                validWeight = weight;
            } else {
                heightReady = heightFt > 0 && heightIn >= 0;
                const totalInches = (heightFt * 12) + heightIn;
                validHeight = totalInches * 2.54;
                validWeight = weight * 0.453592;
            }

            if (heightReady) {
                document.getElementById('height-field').value = isMetric ? heightMetric : document.getElementById('height-field').value;
            }

            document.getElementById('step-2-next').disabled = !(hasGender && age >= 10 && age <= 99 && weightReady && heightReady);
            if (hasGender && age >= 10 && age <= 99 && weightReady && heightReady) {
                document.getElementById('weight-field').dataset.metric = validWeight.toFixed(2);
                document.getElementById('height-field').dataset.metric = validHeight.toFixed(2);
            }
        }

        function validateStep3() {
            const days = Number(document.getElementById('days-field').value);
            const ready = !!state.activity_level && days >= 1 && days <= 7;
            document.getElementById('step-3-next').disabled = !ready;
        }

        function validateMotivationOther() {
            const text = document.getElementById('motivation-other-field').value.trim();
            document.getElementById('motivation-hidden').value = text;
            state.motivation = text;
            document.getElementById('step-4-next').disabled = text.length < 10;
        }

        function validateStep4() {
            const chosen = state.motivation && state.motivation !== 'other';
            document.getElementById('step-4-next').disabled = !chosen;
        }

        function validateSourceOther() {
            const text = document.getElementById('source-other-field').value.trim();
            document.getElementById('source-hidden').value = text;
            state.source = text;
            document.getElementById('step-5-submit').disabled = text.length < 1;
        }

        function goStep(step) {
            document.querySelectorAll('.step-card').forEach(card => card.classList.add('hidden'));
            document.getElementById(`step-${step}`).classList.remove('hidden');
            updateProgress(step);
        }

        function updateProgress(step) {
            for (let i = 1; i <= 5; i++) {
                const element = document.getElementById(`progress-${i}`);
                element.classList.toggle('bg-green-400', i <= step);
                element.classList.toggle('bg-gray-700', i > step);
            }
        }

        document.getElementById('onboarding-form').addEventListener('submit', function (event) {
            const age = Number(document.getElementById('age-field').value);
            const weight = Number(document.getElementById('weight-field').value);
            const isMetric = state.unit === 'metric';
            const heightMetric = Number(document.getElementById('height-field').value);
            const heightFt = Number(document.getElementById('height-ft-field').value);
            const heightIn = Number(document.getElementById('height-in-field').value);

            if (!isMetric) {
                if (Number.isFinite(weight)) {
                    document.getElementById('weight-field').dataset.metric = (weight * 0.453592).toFixed(2);
                }
                const totalInches = (heightFt * 12) + heightIn;
                document.getElementById('height-field').dataset.metric = (totalInches * 2.54).toFixed(2);
            }

            const metricWeight = Number(document.getElementById('weight-field').dataset.metric || weight);
            const metricHeight = Number(document.getElementById('height-field').dataset.metric || heightMetric);
            document.getElementById('onboarding-form').insertAdjacentHTML('beforeend', `
                <input type="hidden" name="weight_kg" value="${metricWeight.toFixed(2)}" />
                <input type="hidden" name="height_cm" value="${metricHeight.toFixed(2)}" />
            `);
        });

        setUnit('metric');
        goStep(1);
    </script>
</x-app-layout>
