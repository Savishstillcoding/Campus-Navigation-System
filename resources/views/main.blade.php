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
        <header class="content-header">
          <h2>Room Directory</h2>
          <p class="subtitle">Browse the rooms in the LNU IT Building.</p>
        </header>

        <!-- Search and Filters -->
        <div class="room-controls">
          <div class="search-box">
            <input 
              type="text" 
              id="roomSearch" 
              class="search-input" 
              placeholder="Search by room number or name..."
            >
            <span class="search-icon">🔍</span>
          </div>

          <div class="filter-buttons">
            <button class="filter-btn active" data-floor="all">All Floors</button>
            <button class="filter-btn" data-floor="2">Floor 2</button>
            <button class="filter-btn" data-floor="3">Floor 3</button>
          </div>
        </div>

        <!-- Room Cards Grid -->
        <div class="rooms-grid" id="roomsGrid">
          <!-- Room cards will be populated here -->
        </div>
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
    let allRooms = [];
    let currentFloor = 'all';
    let searchQuery = '';
    let roomsLoaded = false;

    // Load rooms from API
    async function loadRooms() {
      if (roomsLoaded) return;
      
      try {
        const response = await fetch('/api/qr/rooms');
        const result = await response.json();
        allRooms = result.data || [];
        roomsLoaded = true;
        console.log('Rooms loaded:', allRooms);
        
        // Initial render of all rooms
        renderRooms(allRooms);
        
        // Setup event listeners for search and filters
        setupEventListeners();
      } catch (error) {
        console.error('Error loading rooms:', error);
      }
    }

    // Setup search and filter event listeners
    function setupEventListeners() {
      const searchInput = document.getElementById('roomSearch');
      const filterBtns = document.querySelectorAll('.filter-btn');

      console.log('Setting up event listeners. Filter buttons:', filterBtns.length);

      if (searchInput) {
        searchInput.addEventListener('input', (e) => {
          searchQuery = e.target.value.toLowerCase();
          filterAndRenderRooms();
        });
      }

      filterBtns.forEach((btn) => {
        btn.addEventListener('click', (e) => {
          e.preventDefault();
          
          console.log('Filter button clicked:', btn.getAttribute('data-floor'));
          
          // Remove active class from all buttons
          filterBtns.forEach(b => b.classList.remove('active'));
          
          // Add active class to clicked button
          btn.classList.add('active');
          
          // Update current floor
          currentFloor = btn.getAttribute('data-floor');
          
          console.log('Current floor set to:', currentFloor);
          
          // Filter and render
          filterAndRenderRooms();
        });
      });
    }

    // Filter and render rooms based on search and floor
    function filterAndRenderRooms() {
      console.log('Filtering rooms. Current floor:', currentFloor, 'Search:', searchQuery);
      
      let filtered = [...allRooms];
      
      // Apply floor filter
      if (currentFloor !== 'all') {
        filtered = filtered.filter(room => room.floor.toString() === currentFloor);
        console.log('After floor filter:', filtered.length);
      }
      
      // Apply search filter
      if (searchQuery !== '') {
        filtered = filtered.filter(room =>
          room.room_name.toLowerCase().includes(searchQuery) ||
          room.room_number.includes(searchQuery) ||
          room.description.toLowerCase().includes(searchQuery)
        );
        console.log('After search filter:', filtered.length);
      }

      renderRooms(filtered);
    }

    // Render room cards
    function renderRooms(rooms) {
      const grid = document.getElementById('roomsGrid');
      
      if (!grid) {
        console.error('Grid element not found');
        return;
      }

      const roomsToRender = rooms || allRooms;
      console.log('Rendering', roomsToRender.length, 'rooms');

      if (roomsToRender.length === 0) {
        grid.innerHTML = `
          <div style="grid-column: 1/-1;">
            <div class="no-results">
              <div class="no-results-icon">🔍</div>
              <div class="no-results-text">No rooms found</div>
              <p style="font-size: 13px;">Try adjusting your search or filter</p>
            </div>
          </div>
        `;
        return;
      }

      grid.innerHTML = roomsToRender.map(room => `
        <div class="room-card" data-floor="${room.floor}" data-room-id="${room.id}">
          <div class="room-card-header">
            <div class="room-card-title">${room.room_name}</div>
            <button class="room-card-link" title="View details">🔗</button>
          </div>
          <div class="room-card-type">${room.description}</div>
          <div class="room-card-info">
            <div class="room-card-location">
              ${room.location || `Floor ${room.floor} • Room ${room.room_number}`}
            </div>
          </div>
        </div>
      `).join('');

      // Add click handlers to room cards
      document.querySelectorAll('.room-card-link').forEach(btn => {
        btn.addEventListener('click', (e) => {
          e.stopPropagation();
        });
      });
    }

    // Menu navigation
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

        // Load rooms if rooms section is clicked
        if (sectionName === 'rooms') {
          loadRooms();
        }
      });
    });

    // Load rooms when page loads
    document.addEventListener('DOMContentLoaded', function() {
      console.log('Page loaded, loading rooms');
      loadRooms();
    });
  </script>
</body>
</html>
