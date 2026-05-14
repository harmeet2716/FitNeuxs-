<x-app-layout>
    <style>
      .profile-card {
        background: #FFFFFF;
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 2.5rem;
        padding: 2.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
        margin-bottom: 2rem;
      }
      
      .profile-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #0F172A;
        margin-bottom: 1.5rem;
        letter-spacing: -0.025em;
      }

      .avatar-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 2rem;
      }

      .avatar-frame {
        width: 140px;
        height: 140px;
        border-radius: 3rem;
        border: 4px solid #FFFFFF;
        box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
        cursor: pointer;
        background: #F8FAFC;
        transition: transform 0.3s ease;
      }
      .avatar-frame:hover { transform: scale(1.02); }
      .avatar-frame img { width: 100%; height: 100%; object-fit: cover; }
      
      .avatar-initials {
        width: 100%; height: 100%;
        display: flex; align-items: center; justify-content: center;
        font-size: 2.5rem; font-weight: 800; color: #FF8B3D;
        background: #FFF7ED;
      }

      .avatar-edit-badge {
        position: absolute; bottom: 0; left: 0; right: 0;
        background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(4px);
        color: white; font-size: 10px; font-weight: 800; text-transform: uppercase;
        padding: 8px 0; text-align: center; letter-spacing: 0.1em;
      }

      .metric-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
      }
      @media (min-width: 1024px) { .metric-grid { grid-template-columns: repeat(4, 1fr); } }

      .metric-item {
        background: #FDFBF9;
        border: 1px solid rgba(0, 0, 0, 0.03);
        border-radius: 2rem;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
      }
      .metric-item:hover { background: #FFFFFF; border-color: #FF8B3D; transform: translateY(-4px); box-shadow: 0 10px 20px -5px rgba(255, 139, 61, 0.1); }
      .metric-value { font-size: 1.75rem; font-weight: 800; color: #FF8B3D; margin-bottom: 0.25rem; }
      .metric-label { font-size: 11px; font-weight: 800; color: #94A3B8; text-transform: uppercase; letter-spacing: 0.1em; }

      .input-field {
        width: 100%;
        background: #F8FAFC;
        border: 1px solid rgba(0, 0, 0, 0.05);
        color: #0F172A;
        padding: 1rem 1.5rem;
        border-radius: 1.25rem;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.2s;
      }
      .input-field:focus { outline: none; border-color: #FF8B3D; background: #FFFFFF; box-shadow: 0 0 0 4px rgba(255, 139, 61, 0.1); }
      
      .label-text { display: block; font-size: 12px; font-weight: 800; color: #94A3B8; margin-bottom: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; }

      .btn-luxury {
        background: #0F172A; color: white; font-size: 14px; font-weight: 800;
        padding: 1.25rem 2rem; border-radius: 1.25rem; border: none; cursor: pointer;
        width: 100%; transition: all 0.3s ease; box-shadow: 0 10px 20px -5px rgba(15, 23, 42, 0.2);
      }
      .btn-luxury:hover { background: #FF8B3D; transform: translateY(-2px); box-shadow: 0 20px 30px -10px rgba(255, 139, 61, 0.3); }

      .layout-container { display: grid; gap: 2rem; grid-template-columns: 1fr; }
      @media (min-width: 1024px) { .layout-container { grid-template-columns: 350px 1fr; } }
    </style>

    <div class="max-w-7xl mx-auto px-4 py-10">
        @if (session('status') === 'profile-updated' || session('status') === 'fitness-updated')
            <div class="mb-8 p-5 rounded-[1.5rem] bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-bold flex items-center gap-3">
                <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                Profile updated successfully!
            </div>
        @endif

        <div class="layout-container">
            <!-- Side Profile -->
            <div class="space-y-8">
                <div class="profile-card text-center">
                    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="avatar-container">
                        @csrf
                        @method('patch')
                        <div class="avatar-frame" onclick="document.getElementById('profile_photo').click()">
                            @if($user->profile_photo_path)
                                <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profile">
                            @else
                                <div class="avatar-initials">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                            @endif
                            <div class="avatar-edit-badge">Change</div>
                        </div>
                        <input type="file" id="profile_photo" name="profile_photo" style="display: none;" accept="image/*" onchange="this.form.submit()">
                        <div>
                            <h3 class="text-2xl font-extrabold text-slate-900">{{ $user->name }}</h3>
                            <p class="text-slate-400 font-bold text-sm mt-1">{{ $user->email }}</p>
                        </div>
                    </form>

                    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                        @csrf
                        @method('patch')
                        <div class="text-left">
                            <label class="label-text">Update Full Name</label>
                            <input type="text" name="name" class="input-field" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="text-left">
                            <label class="label-text">Update Email</label>
                            <input type="email" name="email" class="input-field" value="{{ old('email', $user->email) }}" required>
                        </div>
                        <button type="submit" class="btn-luxury">Save Account</button>
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="space-y-8">
                @if($user->fitnessProfile)
                <div class="profile-card">
                    <h2 class="profile-title">Key Performance Indicators</h2>
                    <div class="metric-grid">
                        <div class="metric-item">
                            <div class="metric-value">{{ $user->fitnessProfile->bmi ?? '--' }}</div>
                            <div class="metric-label">BMI Index</div>
                        </div>
                        <div class="metric-item">
                            <div class="metric-value">{{ $user->fitnessProfile->body_fat_percent ?? '--' }}%</div>
                            <div class="metric-label">Body Fat</div>
                        </div>
                        <div class="metric-item">
                            <div class="metric-value">{{ $user->fitnessProfile->bmr ?? '--' }}</div>
                            <div class="metric-label">BMR (kcal)</div>
                        </div>
                        <div class="metric-item">
                            <div class="metric-value">{{ $user->fitnessProfile->target_calories ?? '--' }}</div>
                            <div class="metric-label">Target Cal</div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="profile-card">
                    <h2 class="profile-title">Physiology & Fitness Goals</h2>
                    @if($user->fitnessProfile)
                    <form method="post" action="{{ route('fitness.update') }}" class="space-y-8">
                        @csrf
                        @method('patch')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="label-text">Primary Fitness Goal</label>
                                <select name="goal" class="input-field" required>
                                    <option value="fat_loss" {{ $user->fitnessProfile->goal == 'fat_loss' ? 'selected' : '' }}>Reduce Body Fat</option>
                                    <option value="muscle_gain" {{ $user->fitnessProfile->goal == 'muscle_gain' ? 'selected' : '' }}>Gain Muscle</option>
                                    <option value="strength" {{ $user->fitnessProfile->goal == 'strength' ? 'selected' : '' }}>Build Strength</option>
                                    <option value="stay_active" {{ $user->fitnessProfile->goal == 'stay_active' ? 'selected' : '' }}>Stay Active</option>
                                    <option value="boost_energy" {{ $user->fitnessProfile->goal == 'boost_energy' ? 'selected' : '' }}>Boost Energy</option>
                                </select>
                            </div>
                            <div>
                                <label class="label-text">Biological Gender</label>
                                <select name="gender" class="input-field" required>
                                    <option value="male" {{ $user->fitnessProfile->gender == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ $user->fitnessProfile->gender == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div>
                                <label class="label-text">Age</label>
                                <input type="number" name="age" class="input-field" value="{{ $user->fitnessProfile->age }}" required min="10" max="99">
                            </div>
                            <div>
                                <label class="label-text">Weight (kg)</label>
                                <input type="number" step="0.1" name="weight_kg" class="input-field" value="{{ $user->fitnessProfile->weight_kg }}" required>
                            </div>
                            <div>
                                <label class="label-text">Height (cm)</label>
                                <input type="number" step="0.1" name="height_cm" class="input-field" value="{{ $user->fitnessProfile->height_cm }}" required>
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="btn-luxury" style="width: auto; padding-left: 3rem; padding-right: 3rem;">Update Physiology</button>
                        </div>
                    </form>
                    @else
                    <div class="text-center py-10 bg-slate-50 rounded-[2rem] border border-dashed border-slate-200">
                        <p class="text-slate-400 font-bold mb-6">Complete your profile to unlock AI analytics</p>
                        <a href="{{ route('onboarding') }}" class="btn-luxury" style="width: auto; display: inline-block;">Start Onboarding</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
