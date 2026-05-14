<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account - {{ config('app.name', 'FitNexus') }}</title>
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

      :root {
        --neon-cyan: #00F2FF;
        --neon-hover: #55f7ff;
        --bg-dark: #0A0A0B;
        --card-bg: rgba(255, 255, 255, 0.03);
        --border-color: rgba(255, 255, 255, 0.05);
        --text-main: #ffffff;
        --text-muted: #94A3B8;
      }

      body {
        margin: 0;
        padding: 0;
        font-family: 'Outfit', sans-serif;
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
        background: radial-gradient(circle at 70% 50%, rgba(0, 242, 255, 0.05) 0%, rgba(0,0,0,0.9) 100%);
        z-index: -2;
      }
      
      .bg-silhouette {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background-image: url('https://images.unsplash.com/photo-1581009146145-b5ef050c2e1e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
        background-size: cover;
        background-position: center;
        filter: blur(8px) brightness(0.2) contrast(1.2);
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
        background: var(--neon-cyan);
        mask: url("data:image/svg+xml,%3Csvg viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M13 10V3L4 14h7v7l9-11h-7z'/%3E%3C/svg%3E") center/contain no-repeat;
        -webkit-mask: url("data:image/svg+xml,%3Csvg viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M13 10V3L4 14h7v7l9-11h-7z'/%3E%3C/svg%3E") center/contain no-repeat;
      }
      .logo-text {
        font-size: 20px;
        font-weight: 900;
        letter-spacing: 4px;
        font-family: 'Syncopate', sans-serif;
        text-transform: uppercase;
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
        color: var(--neon-cyan);
      }

      /* Main Layout */
      .main-content {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 100px 60px 40px 60px;
        z-index: 1;
        max-width: 1400px;
        margin: 0 auto;
        width: 100%;
        box-sizing: border-box;
        gap: 80px;
      }

      /* Left Side Text */
      .hero-text {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        max-width: 500px;
      }
      .lightning-icon {
        width: 32px;
        height: 32px;
        background: var(--neon-cyan);
        mask: url("data:image/svg+xml,%3Csvg viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M13 10V3L4 14h7v7l9-11h-7z'/%3E%3C/svg%3E") center/contain no-repeat;
        -webkit-mask: url("data:image/svg+xml,%3Csvg viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M13 10V3L4 14h7v7l9-11h-7z'/%3E%3C/svg%3E") center/contain no-repeat;
        margin-bottom: 24px;
        filter: drop-shadow(0 0 15px rgba(0, 242, 255, 0.6));
      }
      .hero-title {
        font-size: 56px;
        font-weight: 900;
        line-height: 1;
        margin: 0 0 24px 0;
        letter-spacing: -2px;
        font-family: 'Syncopate', sans-serif;
        text-transform: uppercase;
      }
      .hero-title .highlight {
        color: var(--neon-cyan);
      }
      .hero-subtitle {
        font-size: 18px;
        color: var(--text-muted);
        font-weight: 400;
        line-height: 1.5;
        margin: 0;
      }

      /* Right Side Card */
      .login-wrapper {
        flex: 1;
        display: flex;
        justify-content: center;
      }
      .login-card {
        width: 100%;
        max-width: 480px;
        background: var(--card-bg);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border: 1px solid var(--border-color);
        border-radius: 24px;
        padding: 48px 40px;
        box-shadow: 0 50px 100px -20px rgba(0, 0, 0, 0.8), inset 0 0 0 1px rgba(255,255,255,0.05);
        animation: float 8s ease-in-out infinite;
      }

      @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
      }

      .form-header {
        margin-bottom: 32px;
      }
      .form-title {
        font-size: 32px;
        font-weight: 700;
        margin: 0 0 8px 0;
        letter-spacing: -0.5px;
      }
      .form-subtitle {
        font-size: 14px;
        color: var(--text-muted);
        margin: 0;
      }

      /* Session Status */
      .session-status {
        background: rgba(0, 242, 255, 0.1);
        border: 1px solid rgba(0, 242, 255, 0.2);
        color: var(--neon-cyan);
        padding: 12px 16px;
        border-radius: 12px;
        font-size: 14px;
        margin-bottom: 24px;
        text-align: center;
      }

      /* Form Fields */
      .field-group {
        margin-bottom: 20px;
        position: relative;
      }
      .field-label {
        display: block;
        font-size: 13px;
        font-weight: 500;
        color: var(--text-muted);
        margin-bottom: 8px;
      }
      .input-wrapper {
        position: relative;
      }
      .field-input {
        width: 100%;
        background: rgba(0, 0, 0, 0.5);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 14px 16px;
        font-size: 15px;
        color: var(--text-main);
        font-family: inherit;
        transition: all 0.2s ease;
        box-sizing: border-box;
      }
      .field-input:focus {
        outline: none;
        border-color: var(--neon-cyan);
        background: rgba(0, 0, 0, 0.7);
        box-shadow: 0 0 0 4px rgba(0, 242, 255, 0.1);
      }
      .field-input.error {
        border-color: #ef4444;
      }
      .eye-icon {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        color: var(--text-muted);
        cursor: pointer;
        transition: color 0.2s;
      }
      .eye-icon:hover {
        color: var(--text-main);
      }
      .field-error {
        color: #ef4444;
        font-size: 12px;
        margin-top: 6px;
        display: block;
      }

      /* Options Row (Terms) */
      .options-row {
        display: flex;
        align-items: center;
        margin-bottom: 24px;
        margin-top: 8px;
      }
      .remember-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
      }
      .remember-checkbox {
        appearance: none;
        width: 18px;
        height: 18px;
        border: 1px solid var(--border-color);
        border-radius: 4px;
        background: rgba(0, 0, 0, 0.5);
        position: relative;
        cursor: pointer;
        transition: all 0.2s;
      }
      .remember-checkbox:checked {
        background: var(--neon-cyan);
        border-color: var(--neon-cyan);
      }
      .remember-checkbox:checked::after {
        content: '';
        position: absolute;
        left: 6px;
        top: 2px;
        width: 4px;
        height: 9px;
        border: solid #000;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
      }
      .remember-text {
        font-size: 13px;
        color: var(--text-muted);
      }
      .terms-link {
        color: var(--neon-cyan);
        text-decoration: none;
      }
      .terms-link:hover {
        text-decoration: underline;
      }

      /* Submit Button */
      .btn-submit {
        width: 100%;
        background: var(--neon-cyan);
        color: #000;
        border: none;
        border-radius: 12px;
        padding: 16px;
        font-size: 16px;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 0 30px rgba(0, 242, 255, 0.4);
      }
      .btn-submit:hover {
        background: var(--neon-hover);
        transform: translateY(-1px);
        box-shadow: 0 0 40px rgba(0, 242, 255, 0.6);
      }
      .btn-submit:active {
        transform: translateY(1px);
      }

      /* Divider */
      .divider {
        display: flex;
        align-items: center;
        text-align: center;
        margin: 24px 0;
        color: var(--text-muted);
        font-size: 12px;
        font-weight: 500;
      }
      .divider::before, .divider::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid var(--border-color);
      }
      .divider::before { margin-right: 12px; }
      .divider::after { margin-left: 12px; }

      /* Social Button */
      .btn-social {
        width: 100%;
        background: transparent;
        color: var(--text-main);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 14px;
        font-size: 15px;
        font-weight: 500;
        font-family: inherit;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        text-decoration: none;
      }
      .btn-social:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.2);
      }
      .google-icon {
        width: 20px;
        height: 20px;
      }

      /* Footer */
      .form-footer {
        margin-top: 32px;
        text-align: center;
        font-size: 14px;
        color: var(--text-muted);
      }
      .form-footer a {
        color: var(--text-main);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s;
      }
      .form-footer a:hover {
        color: var(--neon-cyan);
      }

      /* Responsive */
      @media (max-width: 992px) {
        .main-content {
          flex-direction: column;
          gap: 40px;
          padding: 120px 40px 40px 40px;
        }
        .hero-text {
          text-align: center;
          align-items: center;
        }
        .hero-title {
          font-size: 48px;
        }
      }

      @media (max-width: 768px) {
        .navbar {
          padding: 20px;
        }
        .nav-right {
          display: none; /* simple mobile nav */
        }
        .main-content {
          padding: 100px 20px 40px 20px;
        }
        .login-card {
          padding: 32px 24px;
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
    <span class="logo-text">FITNEXUS</span>
  </a>
  <div class="nav-right">
    <a href="#" class="nav-link">Exercises</a>
    <a href="#" class="nav-link">Trainers</a>
    <a href="#" class="nav-link">Pricing</a>
    <a href="{{ route('login') }}" class="nav-link">Login</a>
  </div>
</nav>

<!-- Main Layout -->
<div class="main-content">
  
  <!-- Left Side Text -->
  <div class="hero-text">
    <div class="lightning-icon"></div>
    <h1 class="hero-title">Join <span class="highlight">Now</span></h1>
    <p class="hero-subtitle">Start your fitness journey today</p>
  </div>

  <!-- Right Side Form -->
  <div class="login-wrapper">
    <div class="login-card">
      <div class="form-header">
        <h2 class="form-title">Create Account</h2>
        <p class="form-subtitle">Enter your details to get started</p>
      </div>

      <!-- Session Status -->
      @if (session('status'))
        <div class="session-status">
          {{ session('status') }}
        </div>
      @endif

      <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="field-group">
          <label for="name" class="field-label">Full name</label>
          <div class="input-wrapper">
            <input 
              id="name" 
              type="text" 
              name="name" 
              value="{{ old('name') }}" 
              required 
              autofocus 
              autocomplete="name"
              class="field-input {{ $errors->has('name') ? 'error' : '' }}"
            />
          </div>
          @if ($errors->has('name'))
            <span class="field-error">{{ $errors->first('name') }}</span>
          @endif
        </div>

        <!-- Email Address -->
        <div class="field-group">
          <label for="email" class="field-label">Email address</label>
          <div class="input-wrapper">
            <input 
              id="email" 
              type="email" 
              name="email" 
              value="{{ old('email') }}" 
              required 
              autocomplete="username"
              class="field-input {{ $errors->has('email') ? 'error' : '' }}"
            />
          </div>
          @if ($errors->has('email'))
            <span class="field-error">{{ $errors->first('email') }}</span>
          @endif
        </div>

        <!-- Password -->
        <div class="field-group">
          <label for="password" class="field-label">Password</label>
          <div class="input-wrapper">
            <input 
              id="password" 
              type="password" 
              name="password" 
              required 
              autocomplete="new-password"
              class="field-input {{ $errors->has('password') ? 'error' : '' }}"
            />
            <svg class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
              <circle cx="12" cy="12" r="3"></circle>
            </svg>
          </div>
          @if ($errors->has('password'))
            <span class="field-error">{{ $errors->first('password') }}</span>
          @endif
        </div>

        <!-- Confirm Password -->
        <div class="field-group">
          <label for="password_confirmation" class="field-label">Confirm password</label>
          <div class="input-wrapper">
            <input 
              id="password_confirmation" 
              type="password" 
              name="password_confirmation" 
              required 
              autocomplete="new-password"
              class="field-input {{ $errors->has('password_confirmation') ? 'error' : '' }}"
            />
          </div>
          @if ($errors->has('password_confirmation'))
            <span class="field-error">{{ $errors->first('password_confirmation') }}</span>
          @endif
        </div>

        <!-- Terms and Conditions -->
        <div class="options-row">
          <label for="terms" class="remember-wrapper">
            <input id="terms" type="checkbox" name="terms" class="remember-checkbox" required>
            <span class="remember-text">I agree to <a href="#" class="terms-link">terms and conditions</a></span>
          </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-submit">
          Create Account
        </button>

        <!-- Divider -->
        <div class="divider">OR</div>

        <!-- Social Login -->
        <a href="/auth/google" class="btn-social">
          <svg class="google-icon" viewBox="0 0 24 24">
            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
          </svg>
          Continue with Google
        </a>

        <!-- Login Link -->
        <div class="form-footer">
          Already have an account? <a href="{{ route('login') }}">Login here</a>
        </div>
      </form>
      
    </div>
  </div>
</div>
</body>
</html>
