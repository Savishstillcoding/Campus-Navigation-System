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

    <form id="loginForm">
      <label for="studentId">Student ID</label>
      <input type="text" id="studentId" placeholder="e.g. 2023-12345">

      <label for="password">Password</label>
      <input type="password" id="password" placeholder="••••••••">

      <button type="submit" class="signin-btn">Sign in</button>
    </form>

    <p class="note">Demo Mode – Any ID and password will work for this demonstration.</p>
  </main>

  <script>
    document.getElementById('loginForm').addEventListener('submit', e => {
      e.preventDefault();
      alert('Signed in successfully (demo mode)');
      window.location.href = "{{ route('student-home') }}";
    });

    const studentTab = document.getElementById('studentTab');
    const visitorTab = document.getElementById('visitorTab');

    studentTab.addEventListener('click', () => {
      studentTab.classList.add('active');
      visitorTab.classList.remove('active');
    });

    visitorTab.addEventListener('click', () => {
      visitorTab.classList.add('active');
      studentTab.classList.remove('active');
    });
  </script>
</body>
</html>
