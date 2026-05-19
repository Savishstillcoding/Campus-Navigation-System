<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MyCampus Portal</title>
  <link rel="stylesheet" href="{{ asset('css/portal.css') }}">
</head>
<body>
  <div class="sidebar">
    <h2>MyCampus</h2>
    <nav>
      <a href="#">Home</a>
      <a href="#">Room Directory</a>
      <a href="#">Navigation Map</a>
      <a href="#">Activity Log</a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout-btn">Logout</button>
      </form>
    </nav>
  </div>

  <div class="main-content">
    <section id="home">
      <h1>Welcome back, Juan!</h1>
      <div class="buttons">
        <button>Room Directory</button>
        <button>Navigation Map</button>
        <button>Back to Home</button>
      </div>
    </section>

    <section id="room-directory">
      <h2>Room Directory</h2>
      <ul>
        <li>COMLAB 1 – Room ID: 101</li>
        <li>COMLAB 2 – Room ID: 102</li>
        <li>COMLAB 3 – Room ID: 103</li>
        <li>CHEM ROOM – Room ID: 201</li>
        <li>PHYS ROOM – Room ID: 202</li>
        <li>FACULTY ROOM – Room ID: 301</li>
      </ul>
    </section>

    <section id="navigation-map">
      <h2>Navigation Map</h2>
      <div class="floors">
        <button>First Floor</button>
        <button>Second Floor</button>
        <button>Third Floor</button>
      </div>
    </section>

    <section id="activity-log">
      <h2>Activity Log</h2>
      <table>
        <thead>
          <tr><th>Activity</th><th>Date</th><th>Status</th></tr>
        </thead>
        <tbody>
          <tr><td>Scanned QR</td><td>2026-05-18</td><td>DONE</td></tr>
          <tr><td>Visited COMLAB 1</td><td>2026-05-17</td><td>PENDING</td></tr>
        </tbody>
      </table>
    </section>
  </div>

  <script>
    // Sidebar navigation demo
    const links = document.querySelectorAll('.sidebar nav a');
    const sections = document.querySelectorAll('.main-content section');

    links.forEach((link, index) => {
      link.addEventListener('click', e => {
        e.preventDefault();
        sections.forEach(sec => sec.style.display = 'none');
        sections[index].style.display = 'block';
      });
    });

    // Show home by default
    sections.forEach(sec => sec.style.display = 'none');
    document.getElementById('home').style.display = 'block';
  </script>
</body>
</html>
