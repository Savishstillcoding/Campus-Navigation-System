<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LNU Smart Nav</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
  <header>
    <h1>LNU Smart Nav</h1>
    <div class="auth-buttons">
      <a href="{{ route('signin') }}" class="btn">Sign In</a>
      <a href="{{ route('signup') }}" class="btn sign-up">Sign Up</a>
    </div>
  </header>

  <main>
    <h2>Smart Campus Navigation System</h2>
    <p>Navigate the LNU IT Building effortlessly. Scan QR codes to find rooms, track your activity, and access the interactive floor map.</p>

    <div class="qr-section">
      <!-- Replace with actual QR code image -->
      <img src="qr-placeholder.png" alt="QR Code">
      <div><a href="#" class="enter-link">Enter Website</a></div>
    </div>
  </main>

  <footer>
    © 2026 Leyte Normal University - IT Department. All rights reserved.
  </footer>

  <script>
    // Example JS interaction
    document.querySelector('.sign-up').addEventListener('click', () => {
      alert('Sign Up functionality coming soon!');
    });
  </script>
</body>
</html>
