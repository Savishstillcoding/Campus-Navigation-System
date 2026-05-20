<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LNU Smart Nav - Smart Campus Navigation</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: #fff;
      color: #1f2937;
      line-height: 1.6;
    }

    /* HEADER & NAVIGATION */
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 40px;
      background: #fff;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 12px;
      font-size: 24px;
      font-weight: 700;
      color: #FFC107;
    }

    .logo-icon {
      width: 36px;
      height: 36px;
      background: linear-gradient(135deg, #FFC107 0%, #FFB300 100%);
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 800;
    }

    .nav-buttons {
      display: flex;
      gap: 12px;
    }

    .btn {
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      font-family: 'Inter', sans-serif;
    }

    .btn-signin {
      background: transparent;
      color: #1e40af;
      border: 1px solid #e5e7eb;
    }

    .btn-signin:hover {
      background: #f3f4f6;
    }

    .btn-signup {
      background: #FFC107;
      color: #1f2937;
    }

    .btn-signup:hover {
      background: #FFB300;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
    }

    /* HERO SECTION */
    .hero {
      padding: 80px 40px;
      background: linear-gradient(135deg, #f0f9ff 0%, #f5f3ff 100%);
      text-align: center;
    }

    .hero-content {
      max-width: 800px;
      margin: 0 auto;
    }

    .hero h1 {
      font-size: 48px;
      font-weight: 800;
      margin-bottom: 16px;
      color: #0f172a;
      line-height: 1.2;
    }

    .hero-subtitle {
      font-size: 18px;
      color: #64748b;
      margin-bottom: 32px;
      line-height: 1.8;
    }

    .hero-buttons {
      display: flex;
      gap: 16px;
      justify-content: center;
      flex-wrap: wrap;
      margin-bottom: 60px;
    }

    .btn-primary {
      padding: 14px 32px;
      background: #FFC107;
      color: #1f2937;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      font-family: 'Inter', sans-serif;
    }

    .btn-primary:hover {
      background: #FFB300;
      transform: translateY(-3px);
      box-shadow: 0 8px 16px rgba(255, 193, 7, 0.3);
    }

    .btn-secondary {
      padding: 14px 32px;
      background: #f3f4f6;
      color: #1f2937;
      border: 1px solid #e5e7eb;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      font-family: 'Inter', sans-serif;
    }

    .btn-secondary:hover {
      background: #e5e7eb;
      transform: translateY(-3px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    /* FEATURES SECTION */
    .features {
      padding: 80px 40px;
      background: #fff;
    }

    .features-container {
      max-width: 1200px;
      margin: 0 auto;
    }

    .features-header {
      text-align: center;
      margin-bottom: 60px;
    }

    .features-header h2 {
      font-size: 36px;
      font-weight: 800;
      margin-bottom: 12px;
      color: #0f172a;
    }

    .features-header p {
      font-size: 16px;
      color: #64748b;
    }

    .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 32px;
    }

    .feature-card {
      padding: 32px;
      background: #f8fafc;
      border-radius: 12px;
      border: 1px solid #e2e8f0;
      transition: all 0.3s ease;
    }

    .feature-card:hover {
      background: #f0f9ff;
      border-color: #2563eb;
      transform: translateY(-4px);
      box-shadow: 0 12px 24px rgba(37, 99, 235, 0.1);
    }

    .feature-icon {
      font-size: 40px;
      margin-bottom: 16px;
    }

    .feature-card h3 {
      font-size: 18px;
      font-weight: 700;
      margin-bottom: 12px;
      color: #1f2937;
    }

    .feature-card p {
      font-size: 14px;
      color: #64748b;
      line-height: 1.6;
    }

    /* HOW IT WORKS SECTION */
    .how-it-works {
      padding: 80px 40px;
      background: linear-gradient(135deg, #f0f9ff 0%, #f5f3ff 100%);
    }

    .how-container {
      max-width: 800px;
      margin: 0 auto;
      text-align: center;
    }

    .how-container h2 {
      font-size: 36px;
      font-weight: 800;
      margin-bottom: 60px;
      color: #0f172a;
    }

    .steps {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 40px;
      margin-bottom: 40px;
    }

    .step {
      position: relative;
    }

    .step-number {
      width: 48px;
      height: 48px;
      background: #2563eb;
      color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 18px;
      margin: 0 auto 16px;
    }

    .step h3 {
      font-size: 16px;
      font-weight: 600;
      margin-bottom: 8px;
      color: #1f2937;
    }

    .step p {
      font-size: 14px;
      color: #64748b;
    }

    /* CTA SECTION */
    .cta {
      padding: 80px 40px;
      background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
      color: white;
      text-align: center;
    }

    .cta-content {
      max-width: 600px;
      margin: 0 auto;
    }

    .cta h2 {
      font-size: 36px;
      font-weight: 800;
      margin-bottom: 16px;
    }

    .cta p {
      font-size: 18px;
      margin-bottom: 32px;
      opacity: 0.95;
    }

    /* FOOTER */
    footer {
      padding: 32px 40px;
      background: #0f172a;
      color: #9ca3af;
      text-align: center;
      font-size: 14px;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
      header {
        padding: 16px 20px;
        flex-direction: column;
        gap: 16px;
      }

      .hero {
        padding: 60px 20px;
      }

      .hero h1 {
        font-size: 32px;
      }

      .hero-subtitle {
        font-size: 16px;
      }

      .features {
        padding: 60px 20px;
      }

      .features-header h2 {
        font-size: 28px;
      }

      .how-it-works {
        padding: 60px 20px;
      }

      .how-container h2 {
        font-size: 28px;
      }

      .cta {
        padding: 60px 20px;
      }

      .cta h2 {
        font-size: 28px;
      }

      .hero-buttons {
        flex-direction: column;
      }

      .btn-primary,
      .btn-secondary {
        width: 100%;
      }
    }
  </style>
</head>
<body>
  <!-- HEADER -->
  <header>
    <div class="logo">
      <div class="logo-icon">📍</div>
      <span>LNU Smart Nav</span>
    </div>
    <div class="nav-buttons">
      <a href="{{ route('signin') }}" class="btn btn-signin">Sign In</a>
      <a href="{{ route('signup') }}" class="btn btn-signup">Sign Up</a>
    </div>
  </header>

  <!-- HERO SECTION -->
  <section class="hero">
    <div class="hero-content">
      <h1>Navigate Your Campus Effortlessly</h1>
      <p class="hero-subtitle">
        Discover room locations instantly using QR codes. Track your activities and explore our interactive floor maps.
      </p>
      <div class="hero-buttons">
        <a href="{{ route('qr-scanner') }}" class="btn-primary">📱 Start Scanning</a>
        <a href="{{ route('signin') }}" class="btn-secondary">Sign In to Explore</a>
      </div>
    </div>
  </section>

  <!-- FEATURES SECTION -->
  <section class="features">
    <div class="features-container">
      <div class="features-header">
        <h2>Powerful Features</h2>
        <p>Everything you need to navigate the LNU IT Building</p>
      </div>

      <div class="features-grid">
        <div class="feature-card">
          <div class="feature-icon">📱</div>
          <h3>QR Code Scanning</h3>
          <p>Scan QR codes placed throughout the building to instantly find room locations and information.</p>
        </div>

        <div class="feature-card">
          <div class="feature-icon">🏢</div>
          <h3>Room Directory</h3>
          <p>Browse all available rooms with detailed information about locations, floors, and descriptions.</p>
        </div>

        <div class="feature-card">
          <div class="feature-icon">🗺️</div>
          <h3>Interactive Maps</h3>
          <p>View interactive floor plans and navigate the building with ease using our digital maps.</p>
        </div>

        <div class="feature-card">
          <div class="feature-icon">📊</div>
          <h3>Activity Tracking</h3>
          <p>Keep track of your visited locations and maintain a history of your campus activities.</p>
        </div>

        <div class="feature-card">
          <div class="feature-icon">🔍</div>
          <h3>Smart Search</h3>
          <p>Search for rooms by name, number, or location. Find exactly what you're looking for quickly.</p>
        </div>

        <div class="feature-card">
          <div class="feature-icon">👥</div>
          <h3>Visitor Access</h3>
          <p>Guest users can access room information and navigation without creating an account.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- HOW IT WORKS -->
  <section class="how-it-works">
    <div class="how-container">
      <h2>How It Works</h2>
      <div class="steps">
        <div class="step">
          <div class="step-number">1</div>
          <h3>Sign In</h3>
          <p>Create an account or sign in as a visitor</p>
        </div>
        <div class="step">
          <div class="step-number">2</div>
          <h3>Scan QR</h3>
          <p>Use your phone to scan QR codes</p>
        </div>
        <div class="step">
          <div class="step-number">3</div>
          <h3>Find Rooms</h3>
          <p>Get instant location information</p>
        </div>
        <div class="step">
          <div class="step-number">4</div>
          <h3>Navigate</h3>
          <p>Use maps to find your way around</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA SECTION -->
  <section class="cta">
    <div class="cta-content">
      <h2>Ready to Get Started?</h2>
      <p>Join the smart navigation experience at LNU IT Building</p>
      <a href="{{ route('signup') }}" class="btn-primary" style="background: white; color: #2563eb;">Create Your Account</a>
    </div>
  </section>

  <!-- FOOTER -->
  <footer>
    © 2026 Leyte Normal University - IT Department. All rights reserved.
  </footer>
</body>
</html>
