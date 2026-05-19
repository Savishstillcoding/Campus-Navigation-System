<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Create Account - LNU Smart Nav</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Inter', sans-serif;
      background: #f8fafc;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 32px 16px;
    }
    .container {
      background: #fff;
      border-radius: 16px;
      padding: 40px 48px;
      width: 100%;
      max-width: 460px;
      box-shadow: 0 4px 24px rgba(0,0,0,0.08);
      text-align: center;
    }
    .logo-icon { width: 40px; height: 40px; margin: 0 auto 16px; }
    .logo-icon svg { width: 40px; height: 40px; }
    h1 { font-size: 22px; font-weight: 700; color: #0f172a; margin-bottom: 6px; }
    .sub { font-size: 13px; color: #64748b; margin-bottom: 24px; }
    .sub a { color: #2563eb; text-decoration: none; font-weight: 500; }
    .sub a:hover { text-decoration: underline; }

    /* TABS */
    .tabs {
      display: flex;
      background: #f1f5f9;
      border-radius: 8px;
      padding: 4px;
      margin-bottom: 24px;
    }
    .tab {
      flex: 1;
      padding: 8px;
      border-radius: 6px;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      border: none;
      background: transparent;
      color: #64748b;
      transition: all 0.2s;
      font-family: 'Inter', sans-serif;
    }
    .tab.active { background: #fff; color: #1e293b; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }

    /* FORM */
    .form-group { text-align: left; margin-bottom: 16px; }
    label { display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 6px; }
    input[type="text"], input[type="password"], input[type="email"] {
      width: 100%;
      padding: 10px 14px;
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      font-size: 14px;
      color: #1e293b;
      outline: none;
      transition: border-color 0.2s;
      font-family: 'Inter', sans-serif;
    }
    input:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.1); }
    input::placeholder { color: #94a3b8; }

    .btn-submit {
      width: 100%;
      padding: 12px;
      background: #2563eb;
      color: #fff;
      border: none;
      border-radius: 8px;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.2s;
      font-family: 'Inter', sans-serif;
      margin-top: 8px;
    }
    .btn-submit:hover { background: #1d4ed8; }
  </style>
</head>
<body>
  <div class="container">
    <div class="logo-icon">
      <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M20 4L6 11v10c0 8.75 5.9 16.9 14 18.9C28.1 37.9 34 29.75 34 21V11L20 4z" fill="#dbeafe" stroke="#2563eb" stroke-width="2"/>
        <path d="M14 20l4 4 8-8" stroke="#2563eb" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
    <h1>Create an account</h1>
    <p class="sub">Already have an account? <a href="{{ route('signin') }}">Sign in instead</a></p>

    @if ($errors->any())
      <div style="background: #fee; color: #c00; padding: 10px; border-radius: 4px; margin-bottom: 20px; text-align: left;">
        @foreach ($errors->all() as $error)
          <p style="margin: 4px 0; font-size: 13px;">{{ $error }}</p>
        @endforeach
      </div>
    @endif

    <div class="tabs">
      <button class="tab active">Student</button>
    </div>

    <form method="POST" action="{{ route('signup.store') }}">
      @csrf
      <div class="form-group">
        <label>Full Name</label>
        <input type="text" name="name" placeholder="Juan Dela Cruz" value="{{ old('name') }}" required/>
      </div>
      <div class="form-group">
        <label>Student ID</label>
        <input type="text" name="student_id" placeholder="2024-12345" value="{{ old('student_id') }}" required/>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="••••••••" required/>
      </div>
      <div class="form-group">
        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" placeholder="••••••••" required/>
      </div>

      <button type="submit" class="btn-submit">Create Account</button>
    </form>
  </div>
</body>
</html>
