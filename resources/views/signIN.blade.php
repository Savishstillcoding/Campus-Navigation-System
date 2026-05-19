<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Sign In</title>
  <link rel="stylesheet" href="{{ asset('css/signin.css') }}">
</head>
<body>
  <main class="login-container">
    <h2>Sign in to your account</h2>
    <p class="subheading">Or create a new account</p>

    <div class="tabs">
      <button class="tab active" id="studentTab">Student</button>
      <button class="tab" id="visitorTab">Visitor</button>
    </div>

    @if ($errors->any())
      <div style="background: #fee; color: #c00; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
        @foreach ($errors->all() as $error)
          <p>{{ $error }}</p>
        @endforeach
      </div>
    @endif

    <!-- Student Form -->
    <form method="POST" action="{{ route('signin.store') }}" id="studentForm" class="login-form active">
      @csrf
      <label for="student_id">Student ID</label>
      <input type="text" id="student_id" name="student_id" placeholder="2024-12345" value="{{ old('student_id') }}" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="••••••••" required>

      <button type="submit" class="signin-btn">Sign in</button>
    </form>

    <!-- Visitor Form -->
    <form method="POST" action="{{ route('visitor.signin') }}" id="visitorForm" class="login-form" style="display: none;">
      @csrf
      <label for="visitor_name">Full Name</label>
      <input type="text" id="visitor_name" name="name" placeholder="Juan Dela Cruz" required>

      <button type="submit" class="signin-btn">Continue as Visitor</button>
    </form>

    <p class="note" id="note-text">Enter your student ID and password to sign in.</p>
  </main>

  <script>
    const studentTab = document.getElementById('studentTab');
    const visitorTab = document.getElementById('visitorTab');
    const studentForm = document.getElementById('studentForm');
    const visitorForm = document.getElementById('visitorForm');
    const noteText = document.getElementById('note-text');

    studentTab.addEventListener('click', () => {
      studentTab.classList.add('active');
      visitorTab.classList.remove('active');
      studentForm.style.display = 'block';
      visitorForm.style.display = 'none';
      noteText.textContent = 'Enter your student ID and password to sign in.';
    });

    visitorTab.addEventListener('click', () => {
      visitorTab.classList.add('active');
      studentTab.classList.remove('active');
      studentForm.style.display = 'none';
      visitorForm.style.display = 'block';
      noteText.textContent = 'Enter your full name to continue as a visitor.';
    });
  </script>
</body>
</html>
