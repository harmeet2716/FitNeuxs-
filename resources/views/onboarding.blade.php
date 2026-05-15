<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Onboarding - {{ config('app.name', 'FitNexus') }}</title>
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

      :root {
        --neon-green: #22C55E;
        --neon-hover: #16a34a;
        --bg-dark: #050505;
        --card-bg: rgba(20, 20, 20, 0.4);
        --border-color: rgba(255, 255, 255, 0.08);
        --text-main: #ffffff;
        --text-muted: #9ca3af;
      }

      body {
        margin: 0;
        padding: 0;
        font-family: 'Inter', sans-serif;
        background-color: var(--bg-dark);
        color: var(--text-main);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        position: relative;
        overflow-x: hidden;
      }

      /* Backgrounds */
      .bg-overlay {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: radial-gradient(circle at 50% 0%, rgba(34, 197, 94, 0.08) 0%, rgba(0,0,0,0.95) 80%);
        z-index: -2;
      }
      
      .bg-silhouette {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background-image: url('https://images.unsplash.com/photo-1540497077202-7c8a3999166f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80'); /* Gym weights */
        background-size: cover;
        background-position: center;
        filter: blur(12px) brightness(0.15) contrast(1.3);
        z-index: -1;
      }

      /* Navigation */
      .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 30px 60px;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        box-sizing: border-box;
        z-index: 10;
      }
      .nav-left {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
      }
      .logo-icon {
        width: 28px;
        height: 28px;
        background: var(--neon-green);
        mask: url("data:image/svg+xml,%3Csvg viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M13 10V3L4 14h7v7l9-11h-7z'/%3E%3C/svg%3E") center/contain no-repeat;
        -webkit-mask: url("data:image/svg+xml,%3Csvg viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M13 10V3L4 14h7v7l9-11h-7z'/%3E%3C/svg%3E") center/contain no-repeat;
      }
      .logo-text {
        font-size: 22px;
        font-weight: 800;
        letter-spacing: 2px;
        color: var(--text-main);
      }
      .nav-right {
        display: flex;
        gap: 32px;
        align-items: center;
      }
      .nav-link {
        color: var(--text-main);
        text-decoration: none;
        font-size: 15px;
        font-weight: 500;
        transition: color 0.2s;
      }
      .nav-link:hover {
        color: var(--neon-green);
      }

      /* Main Layout */
      .main-content {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 120px 20px 40px 20px;
        z-index: 1;
        width: 100%;
        box-sizing: border-box;
      }

      /* Card */
      .onboard-card {
        width: 100%;
        max-width: 560px;
        background: var(--card-bg);
        backdrop-filter: blur(30px);
        -webkit-backdrop-filter: blur(30px);
        border: 1px solid var(--border-color);
        border-radius: 32px;
        padding: 40px;
        box-shadow: 0 40px 80px -20px rgba(0, 0, 0, 0.8), inset 0 1px 0 0 rgba(255,255,255,0.1);
        position: relative;
        overflow: hidden;
      }
      .onboard-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; height: 100px;
        background: linear-gradient(180deg, rgba(34, 197, 94, 0.03) 0%, transparent 100%);
        pointer-events: none;
      }

      /* Progress Bar */
      .progress-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
      }
      .progress-wrapper {
        flex: 1;
        margin-right: 20px;
      }
      .progress-text {
        font-size: 12px;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
        display: block;
      }
      .progress-track {
        height: 4px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 4px;
        overflow: hidden;
        display: flex;
      }
      .progress-fill {
        height: 100%;
        background: var(--neon-green);
        border-radius: 4px;
        transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 0 10px rgba(34, 197, 94, 0.5);
      }
      .btn-skip {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--border-color);
        color: var(--text-muted);
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
      }
      .btn-skip:hover {
        color: var(--text-main);
        background: rgba(255, 255, 255, 0.1);
      }

      /* Headings */
      .step-heading {
        font-size: 36px;
        font-weight: 800;
        line-height: 1.2;
        margin: 0 0 8px 0;
        letter-spacing: -0.5px;
      }
      .step-subheading {
        font-size: 15px;
        color: var(--text-muted);
        margin: 0 0 32px 0;
      }

      /* Vertical Cards */
      .goal-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-bottom: 32px;
      }
      .goal-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: rgba(0, 0, 0, 0.5);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 16px 20px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
      }
      .goal-card:hover {
        background: rgba(20, 20, 20, 0.8);
        border-color: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
      }
      .goal-card.selected {
        background: rgba(34, 197, 94, 0.1);
        border-color: var(--neon-green);
        box-shadow: 0 0 20px rgba(34, 197, 94, 0.2);
        transform: scale(1.02);
      }
      .goal-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
        z-index: 2;
      }
      .goal-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-main);
      }
      .goal-desc {
        font-size: 13px;
        color: var(--text-muted);
      }
      .goal-thumb {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        background-size: cover;
        background-position: center top;
        opacity: 0.8;
        mix-blend-mode: luminosity;
        transition: all 0.3s;
        z-index: 2;
      }
      .goal-card.selected .goal-thumb {
        mix-blend-mode: normal;
        opacity: 1;
        box-shadow: 0 0 15px rgba(34, 197, 94, 0.4);
      }
      
      /* Background Glow for selected card */
      .goal-card::after {
        content: '';
        position: absolute;
        right: -20px; top: -20px; width: 100px; height: 100px;
        background: radial-gradient(circle, rgba(34,197,94,0.2) 0%, transparent 70%);
        opacity: 0;
        transition: opacity 0.3s;
      }
      .goal-card.selected::after {
        opacity: 1;
      }

      /* Bottom Section */
      .btn-next {
        width: 100%;
        background: var(--neon-green);
        color: #000;
        border: none;
        border-radius: 16px;
        padding: 18px;
        font-size: 16px;
        font-weight: 700;
        font-family: inherit;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 0 20px rgba(34, 197, 94, 0.4);
      }
      .btn-next:hover:not(:disabled) {
        background: var(--neon-hover);
        transform: translateY(-2px);
        box-shadow: 0 0 30px rgba(34, 197, 94, 0.6);
      }
      .btn-next:disabled {
        background: rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.3);
        box-shadow: none;
        cursor: not-allowed;
      }

      /* Step Content Visibility */
      .step-content {
        display: none;
        animation: slideIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      }
      .step-content.active {
        display: block;
      }
      
      @keyframes slideIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
      }

      /* Input styling for other steps */
      .tag-grid {
        display: flex; 
        flex-wrap: wrap; 
        gap: 12px; 
        margin-bottom: 32px;
      }
      .tag-btn {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--border-color);
        color: var(--text-main);
        padding: 12px 24px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
      }
      .tag-btn:hover {
        background: rgba(255, 255, 255, 0.1);
      }
      .tag-btn.active {
        background: rgba(34, 197, 94, 0.15);
        border-color: var(--neon-green);
        color: var(--neon-green);
        box-shadow: 0 0 15px rgba(34, 197, 94, 0.2);
      }

      /* Responsive */
      @media (max-width: 768px) {
        .navbar {
          padding: 20px;
        }
        .nav-right {
          display: none;
        }
        .main-content {
          padding: 100px 16px 40px 16px;
        }
        .onboard-card {
          padding: 32px 24px;
        }
        .step-heading {
          font-size: 28px;
        }
      }
    </style>
</head>
<body>

<div class="bg-silhouette"></div>
<div class="bg-overlay"></div>

<!-- Navigation -->
<nav class="navbar">
  <a href="/" class="nav-left">
    <div class="logo-icon"></div>
    <span class="logo-text">WORKOUT</span>
  </a>
  <div class="nav-right">
    <a href="#" class="nav-link">Exercises</a>
    <a href="#" class="nav-link">Trainers</a>
    <a href="#" class="nav-link">Pricing</a>
    <a href="{{ route('login') }}" class="nav-link">Login</a>
  </div>
</nav>

<div class="main-content">
  <div class="onboard-card">
    
    <div class="progress-header">
      <div class="progress-wrapper">
        <span class="progress-text" id="progress-text">Step 1 of 4</span>
        <div class="progress-track">
          <div class="progress-fill" id="progress-fill" style="width: 25%;"></div>
        </div>
      </div>
      <button class="btn-skip" onclick="skipOnboarding()">Skip</button>
    </div>

    <form method="POST" action="{{ route('fitness.store') }}" id="onboarding-form">
      @csrf
      <!-- Hidden fields for submission -->
      <input type="hidden" name="goal" id="goal-field">
      <input type="hidden" name="gender" id="gender-field" value="male">
      <input type="hidden" name="activity_level" id="activity-field" value="beginner">

      <!-- Step 1: Goal -->
      <div class="step-content active" id="step-1">
        <h1 class="step-heading">What is your primary fitness goal?</h1>
        <p class="step-subheading">Personalized programming starts here.</p>

        <div class="goal-list">
          <div class="goal-card" data-value="lose_fat" onclick="selectGoal(this)">
            <div class="goal-info">
              <span class="goal-title">Lose Fat</span>
              <span class="goal-desc">Lean out and reveal definition</span>
            </div>
            <div class="goal-thumb" style="background-image: url('https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80');"></div>
          </div>

          <div class="goal-card" data-value="build_muscle" onclick="selectGoal(this)">
            <div class="goal-info">
              <span class="goal-title">Build Muscle</span>
              <span class="goal-desc">Build size and raw strength</span>
            </div>
            <div class="goal-thumb" style="background-image: url('https://images.unsplash.com/photo-1581009146145-b5ef050c2e1e?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80');"></div>
          </div>

          <div class="goal-card" data-value="maintenance" onclick="selectGoal(this)">
            <div class="goal-info">
              <span class="goal-title">Maintenance</span>
              <span class="goal-desc">Maintain health and mobility</span>
            </div>
            <div class="goal-thumb" style="background-image: url('https://images.unsplash.com/photo-1517836357463-d25dfeac3438?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80');"></div>
          </div>
        </div>

        <button type="button" class="btn-next" id="btn-next-1" disabled onclick="nextStep(2)">Next Step</button>
      </div>

      <!-- Step 2: Personal Details -->
      <div class="step-content" id="step-2">
        <h1 class="step-heading">Tell us about yourself</h1>
        <p class="step-subheading">This helps us calculate your baseline metabolic rate.</p>
        
        <div class="field-group" style="margin-bottom: 24px;">
          <label class="progress-text">Gender</label>
          <div class="tag-grid">
            <div class="tag-btn active" id="gender-male" onclick="selectGender('male')">Male</div>
            <div class="tag-btn" id="gender-female" onclick="selectGender('female')">Female</div>
          </div>
        </div>

        <div class="field-group">
          <label for="age" class="progress-text">Age</label>
          <input type="number" name="age" id="age" value="25" class="tag-btn" style="width: 100%; text-align: left; background: rgba(0,0,0,0.3); border-color: var(--border-color); color: white; padding: 16px;">
        </div>

        <div style="display: flex; gap: 16px; margin-top: 32px;">
          <button type="button" class="btn-skip" style="flex: 1;" onclick="nextStep(1)">Back</button>
          <button type="button" class="btn-next" style="flex: 2;" onclick="nextStep(3)">Next Step</button>
        </div>
      </div>

      <!-- Step 3: Physical Metrics -->
      <div class="step-content" id="step-3">
        <h1 class="step-heading">Your stats</h1>
        <p class="step-subheading">We need your height and weight for accuracy.</p>
        
        <div style="display: flex; gap: 20px; margin-bottom: 32px;">
          <div style="flex: 1;">
            <label for="height_cm" class="progress-text">Height (cm)</label>
            <input type="number" name="height_cm" id="height_cm" value="175" class="tag-btn" style="width: 100%; text-align: left; background: rgba(0,0,0,0.3); border-color: var(--border-color); color: white; padding: 16px;">
          </div>
          <div style="flex: 1;">
            <label for="weight_kg" class="progress-text">Weight (kg)</label>
            <input type="number" name="weight_kg" id="weight_kg" value="70" class="tag-btn" style="width: 100%; text-align: left; background: rgba(0,0,0,0.3); border-color: var(--border-color); color: white; padding: 16px;">
          </div>
        </div>

        <div style="display: flex; gap: 16px;">
          <button type="button" class="btn-skip" style="flex: 1;" onclick="nextStep(2)">Back</button>
          <button type="button" class="btn-next" style="flex: 2;" onclick="nextStep(4)">Next Step</button>
        </div>
      </div>

      <!-- Step 4: Activity Level -->
      <div class="step-content" id="step-4">
        <h1 class="step-heading">How active are you?</h1>
        <p class="step-subheading">Select your typical weekly activity level.</p>
        
        <div class="goal-list">
          <div class="goal-card selected" id="activity-beginner" onclick="selectActivity('beginner')">
            <div class="goal-info">
              <span class="goal-title">Beginner</span>
              <span class="goal-desc">Sedentary or light exercise (1-2 days)</span>
            </div>
          </div>
          <div class="goal-card" id="activity-intermediate" onclick="selectActivity('intermediate')">
            <div class="goal-info">
              <span class="goal-title">Intermediate</span>
              <span class="goal-desc">Moderate exercise (3-5 days)</span>
            </div>
          </div>
          <div class="goal-card" id="activity-advanced" onclick="selectActivity('advanced')">
            <div class="goal-info">
              <span class="goal-title">Advanced</span>
              <span class="goal-desc">Intense training (6-7 days)</span>
            </div>
          </div>
        </div>

        <div style="display: flex; gap: 16px;">
          <button type="button" class="btn-skip" style="flex: 1;" onclick="nextStep(3)">Back</button>
          <button type="submit" class="btn-next" style="flex: 2;">Finish & Build Plan</button>
        </div>
      </div>

    </form>
  </div>
</div>

<script>
  function selectGoal(element) {
    document.querySelectorAll('.goal-card').forEach(el => el.classList.remove('selected'));
    element.classList.add('selected');
    document.getElementById('goal-field').value = element.dataset.value;
    document.getElementById('btn-next-1').disabled = false;
  }

  function selectGender(gender) {
    document.getElementById('gender-male').classList.remove('active');
    document.getElementById('gender-female').classList.remove('active');
    document.getElementById('gender-' + gender).classList.add('active');
    document.getElementById('gender-field').value = gender;
  }

  function selectActivity(level) {
    document.getElementById('activity-beginner').classList.remove('selected');
    document.getElementById('activity-intermediate').classList.remove('selected');
    document.getElementById('activity-advanced').classList.remove('selected');
    document.getElementById('activity-' + level).classList.add('selected');
    document.getElementById('activity-field').value = level;
  }

  function nextStep(step) {
    document.querySelectorAll('.step-content').forEach(el => el.classList.remove('active'));
    document.getElementById('step-' + step).classList.add('active');
    
    const totalSteps = 4;
    const pct = (step / totalSteps) * 100;
    document.getElementById('progress-fill').style.width = pct + '%';
    document.getElementById('progress-text').innerText = 'Step ' + step + ' of ' + totalSteps;
  }

  function skipOnboarding() {
    window.location.href = '/dashboard';
  }
</script>
</body>
</html>
