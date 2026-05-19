<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Portal - LNU Smart Nav</title>
  <link rel="stylesheet" href="{{ asset('css/portal.css') }}">
</head>
<body>
  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="logo-section">
        <div class="logo">📍</div>
        <h1>LNU Smart Nav</h1>
        <p class="subtitle">IT Building</p>
      </div>

      <div class="user-info">
        <h3>
          @if (session('is_visitor'))
            {{ session('visitor_name') }}
          @else
            {{ Auth::user()->name }}
          @endif
        </h3>
        <p class="student-id">
          @if (session('is_visitor'))
            Visitor
          @else
            Student • {{ Auth::user()->student_id }}
          @endif
        </p>
      </div>

      <nav class="menu">
        <a href="#dashboard" class="menu-item active" data-section="dashboard">
          <span class="icon">📊</span> Dashboard
        </a>
        <a href="#rooms" class="menu-item" data-section="rooms">
          <span class="icon">🏢</span> Room Directory
        </a>
        <a href="#map" class="menu-item" data-section="map">
          <span class="icon">🗺️</span> Navigation Map
        </a>
        <a href="#activity" class="menu-item" data-section="activity">
          <span class="icon">📝</span> Activity Log
        </a>
      </nav>

      <form method="POST" action="{{ route('logout') }}" class="logout-section">
        @csrf
        <button type="submit" class="logout-btn">
          <span class="icon">🚪</span> Sign Out
        </button>
      </form>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <!-- Dashboard Section -->
      <section id="dashboard" class="content-section active">
        <header class="content-header">
          <h2>Welcome back, 
            @if (session('is_visitor'))
              {{ session('visitor_name') }}
            @else
              {{ Auth::user()->name }}
            @endif
            !
          </h2>
          <p class="subtitle">Here's your campus navigation overview for today.</p>
        </header>

        <div class="quick-actions">
          <div class="action-card">
            <div class="card-icon">🏢</div>
            <h3>Browse Rooms</h3>
            <p>View all available rooms</p>
          </div>
          <div class="action-card" onclick="window.location.href='{{ route('qr-scanner') }}';" style="cursor: pointer;">
            <div class="card-icon">📱</div>
            <h3>Scan QR Code</h3>
            <p>Find your room</p>
          </div>
          <div class="action-card">
            <div class="card-icon">🗺️</div>
            <h3>View Map</h3>
            <p>Interactive floor map</p>
          </div>
        </div>
      </section>

      <!-- Rooms Section -->
      <section id="rooms" class="content-section">
        <h2>Room Directory</h2>
        <ul class="room-list">
          <li>COMLAB 1 – Room ID: 101</li>
          <li>COMLAB 2 – Room ID: 102</li>
          <li>COMLAB 3 – Room ID: 103</li>
          <li>CHEM ROOM – Room ID: 201</li>
          <li>PHYS ROOM – Room ID: 202</li>
          <li>FACULTY ROOM – Room ID: 301</li>
        </ul>
      </section>

      <!-- Map Section -->
      <section id="map" class="content-section">
        <h2>Navigation Map</h2>
        <div class="floors">
          <button class="floor-btn">First Floor</button>
          <button class="floor-btn">Second Floor</button>
          <button class="floor-btn">Third Floor</button>
        </div>
      </section>

      <!-- Activity Section -->
      <section id="activity" class="content-section">
        <h2>Activity Log</h2>
        <table class="activity-table">
          <thead>
            <tr>
              <th>Activity</th>
              <th>Date</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Scanned QR</td>
              <td>2026-05-18</td>
              <td><span class="badge done">DONE</span></td>
            </tr>
            <tr>
              <td>Visited COMLAB 1</td>
              <td>2026-05-17</td>
              <td><span class="badge pending">PENDING</span></td>
            </tr>
          </tbody>
        </table>
      </section>
    </main>
  </div>

  <script>
    const menuItems = document.querySelectorAll('.menu-item');
    const sections = document.querySelectorAll('.content-section');

    menuItems.forEach(item => {
      item.addEventListener('click', (e) => {
        e.preventDefault();
        const sectionName = item.getAttribute('data-section');

        // Remove active class from all menu items and sections
        menuItems.forEach(m => m.classList.remove('active'));
        sections.forEach(s => s.classList.remove('active'));

        // Add active class to clicked item and corresponding section
        item.classList.add('active');
        document.getElementById(sectionName).classList.add('active');
      });
    });
  </script>
</body>
</html>
