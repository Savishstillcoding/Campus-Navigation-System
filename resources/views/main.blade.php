<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=no">
  <meta name="apple-mobile-web-app-capable" content="true">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <title>Student Portal - LNU Smart Nav</title>
  <link rel="stylesheet" href="/css/portal.css">
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
          <div class="action-card" onclick="navigateToSection('rooms');" style="cursor: pointer;">
            <div class="card-icon">🏢</div>
            <h3>Browse Rooms</h3>
            <p>View all available rooms</p>
          </div>
          <div class="action-card" onclick="window.location.href='{{ route('qr-scanner') }}';" style="cursor: pointer;">
            <div class="card-icon">📱</div>
            <h3>Scan QR Code</h3>
            <p>Find your room</p>
          </div>
          <div class="action-card" onclick="navigateToSection('map');" style="cursor: pointer;">
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
        <header class="content-header">
          <h2>Navigation Map</h2>
          <p class="subtitle">Interactive floor plan of the LNU IT Building.</p>
        </header>
        
        <div class="map-container">
          <!-- Floor Location Header -->
          <div class="map-location">
            <span class="location-icon">📍</span>
            <span class="location-text">IT Building — <span id="currentFloorDisplay">Floor 2</span></span>
          </div>

          <!-- Floor Selection Buttons -->
          <div class="floor-selector">
            <button class="floor-select-btn active" data-floor="2">Floor 2</button>
            <button class="floor-select-btn" data-floor="3">Floor 3</button>
          </div>

          <!-- Floor Plan -->
          <div class="floor-plan" id="floorPlan">
            <!-- Floor plan will be dynamically generated here -->
          </div>

          <!-- Help Text -->
          <div class="map-help-text">
            <span class="info-icon">ℹ️</span>
            Hover over a room to see directions. Click any room to view its QR code and sign in or out.
          </div>
        </div>
      </section>

      <!-- Activity Section -->
      <section id="activity" class="content-section">
        <h2>Activity Log</h2>
        <table class="activity-table">
          <thead>
            <tr>
              <th>Activity</th>
              <th>Date & Time</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody id="activity-log-body">
            <!-- Activity logs will be loaded dynamically here -->
          </tbody>
        </table>
        <div id="no-activity-message" style="text-align: center; padding: 20px; color: #64748b;">
          No activity logged yet. Start scanning QR codes!
        </div>
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
    let scannedRoomId = null;
    let scannedRoomFloor = null;
    let scannedRoomName = null;

    // Load rooms from API
    async function loadRooms() {
      if (roomsLoaded) return Promise.resolve();
      
      return new Promise((resolve) => {
        try {
          fetch('/api/qr/rooms', {
            credentials: 'include',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            }
          })
            .then(response => response.json())
            .then(result => {
              allRooms = result.data || [];
              roomsLoaded = true;
              console.log('Rooms loaded:', allRooms);
              
              // Initial render of all rooms
              renderRooms(allRooms);
              
              // Setup event listeners for search and filters
              setupEventListeners();
              
              resolve();
            })
            .catch(error => {
              console.error('Error loading rooms:', error);
              resolve();
            });
        } catch (error) {
          console.error('Error in loadRooms:', error);
          resolve();
        }
      });
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
            <button class="room-card-link" title="View details" data-room-id="${room.id}">🔗</button>
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
          const roomId = btn.getAttribute('data-room-id');
          window.location.href = `/room/${roomId}`;
        });
      });
    }

    // Menu navigation
    menuItems.forEach(item => {
      item.addEventListener('click', (e) => {
        e.preventDefault();
        const sectionName = item.getAttribute('data-section');
        navigateToSection(sectionName);
      });
    });

    // Navigate to section function
    function navigateToSection(sectionName) {
      // Remove active class from all menu items and sections
      menuItems.forEach(m => m.classList.remove('active'));
      sections.forEach(s => s.classList.remove('active'));

      // Add active class to menu item and section
      const activeMenuItem = document.querySelector(`[data-section="${sectionName}"]`);
      if (activeMenuItem) {
        activeMenuItem.classList.add('active');
      }
      
      const targetSection = document.getElementById(sectionName);
      if (targetSection) {
        targetSection.classList.add('active');
      }

      // Load rooms if rooms section is clicked
      if (sectionName === 'rooms') {
        loadRooms();
      }

      // Render floor plan if map section is clicked
      if (sectionName === 'map') {
        // If there's a scanned room, render that floor first
        if (scannedRoomFloor) {
          const floorNum = parseInt(scannedRoomFloor);
          renderFloorPlan(floorNum);
          
          // Update floor selector buttons
          const floorBtns = document.querySelectorAll('.floor-select-btn');
          floorBtns.forEach(btn => {
            btn.classList.remove('active');
            if (parseInt(btn.getAttribute('data-floor')) === floorNum) {
              btn.classList.add('active');
            }
          });
          
          // Update display
          document.getElementById('currentFloorDisplay').textContent = `Floor ${floorNum}`;
        } else {
          renderFloorPlan(2); // Default to floor 2
        }
      }
    }

    // Floor plan rendering
    function renderFloorPlan(floor) {
      const floorPlanContainer = document.getElementById('floorPlan');
      const floorRooms = allRooms.filter(room => room.floor === floor);
      
      console.log('Floor ' + floor + ' all rooms:', floorRooms);
      
      let html = '<div class="floor-plan-layout">';
      
      if (floor === 2) {
        // Floor 2 layout: Computer Lab 1 & 2 on top, Corridor middle, Computer Lab 3 bottom
        const comlab1 = floorRooms.find(room => room.room_name === 'Computer Lab 1');
        const comlab2 = floorRooms.find(room => room.room_name === 'Computer Lab 2');
        const comlab3 = floorRooms.find(room => room.room_name === 'Computer Lab 3');

        console.log('Floor 2 - Lab 1:', comlab1, 'Lab 2:', comlab2, 'Lab 3:', comlab3);

        // Top row - Computer Lab 1 and 2
        html += '<div class="floor-plan-top">';
        if (comlab1) {
          const isScanned = scannedRoomId && comlab1.id == scannedRoomId;
          html += `
            <div class="room-box ${isScanned ? 'room-box-scanned' : ''}" onclick="window.location.href='/room/${comlab1.id}';" style="cursor: pointer; position: relative;">
              ${isScanned ? '<div class="location-marker">📍 You are currently here</div>' : ''}
              <div class="room-box-icon">🏢</div>
              <div class="room-box-name">${comlab1.room_name}</div>
              <div class="room-box-description">${comlab1.description}</div>
            </div>
          `;
        }
        if (comlab2) {
          const isScanned = scannedRoomId && comlab2.id == scannedRoomId;
          html += `
            <div class="room-box ${isScanned ? 'room-box-scanned' : ''}" onclick="window.location.href='/room/${comlab2.id}';" style="cursor: pointer; position: relative;">
              ${isScanned ? '<div class="location-marker">📍 You are currently here</div>' : ''}
              <div class="room-box-icon">🏢</div>
              <div class="room-box-name">${comlab2.room_name}</div>
              <div class="room-box-description">${comlab2.description}</div>
            </div>
          `;
        }
        html += '</div>';

        // Main Corridor (horizontal)
        html += '<div class="floor-plan-corridor">Main Corridor</div>';

        // Bottom row - Computer Lab 3
        html += '<div class="floor-plan-bottom">';
        if (comlab3) {
          const isScanned = scannedRoomId && comlab3.id == scannedRoomId;
          html += `
            <div class="room-box ${isScanned ? 'room-box-scanned' : ''}" onclick="window.location.href='/room/${comlab3.id}';" style="cursor: pointer; position: relative;">
              ${isScanned ? '<div class="location-marker">📍 You are currently here</div>' : ''}
              <div class="room-box-icon">🏢</div>
              <div class="room-box-name">${comlab3.room_name}</div>
              <div class="room-box-description">${comlab3.description}</div>
            </div>
          `;
        }
        html += '</div>';

        html += '<div class="stairs-section"><span class="stairs-icon">⬆️</span> STAIRS FROM 1ST FLOOR</div>';
      } else if (floor === 3) {
        // Floor 3 layout: 2x2 grid
        // Computer Lab 4 (top-left), CHS Room (top-right)
        // Faculty Room (bottom-left), CISCO Lab (bottom-right)
        const comlab4 = floorRooms.find(room => room.room_name === 'Computer Lab 4');
        const ciscoLab = floorRooms.find(room => room.room_name === 'CISCO Lab');
        const facultyRoom = floorRooms.find(room => room.room_name === 'Faculty Room');
        const chsRoom = floorRooms.find(room => room.room_name === 'CHS Room');

        console.log('Floor 3 - Lab 4:', comlab4, 'CISCO:', ciscoLab, 'Faculty:', facultyRoom, 'CHS:', chsRoom);

        // Top row - Computer Lab 4 and CHS Room
        html += '<div class="floor-plan-top">';
        if (comlab4) {
          const isScanned = scannedRoomId && comlab4.id == scannedRoomId;
          html += `
            <div class="room-box ${isScanned ? 'room-box-scanned' : ''}" onclick="window.location.href='/room/${comlab4.id}';" style="cursor: pointer; position: relative;">
              ${isScanned ? '<div class="location-marker">📍 You are currently here</div>' : ''}
              <div class="room-box-icon">🏢</div>
              <div class="room-box-name">${comlab4.room_name}</div>
              <div class="room-box-description">${comlab4.description}</div>
            </div>
          `;
        }
        if (chsRoom) {
          const isScanned = scannedRoomId && chsRoom.id == scannedRoomId;
          html += `
            <div class="room-box ${isScanned ? 'room-box-scanned' : ''}" onclick="window.location.href='/room/${chsRoom.id}';" style="cursor: pointer; position: relative;">
              ${isScanned ? '<div class="location-marker">📍 You are currently here</div>' : ''}
              <div class="room-box-icon">🏢</div>
              <div class="room-box-name">${chsRoom.room_name}</div>
              <div class="room-box-description">${chsRoom.description}</div>
            </div>
          `;
        }
        html += '</div>';

        // Main Corridor (horizontal)
        html += '<div class="floor-plan-corridor">Main Corridor</div>';

        // Bottom row - Faculty Room and CISCO Lab
        html += '<div class="floor-plan-bottom">';
        if (facultyRoom) {
          const isScanned = scannedRoomId && facultyRoom.id == scannedRoomId;
          html += `
            <div class="room-box ${isScanned ? 'room-box-scanned' : ''}" onclick="window.location.href='/room/${facultyRoom.id}';" style="cursor: pointer; position: relative;">
              ${isScanned ? '<div class="location-marker">📍 You are currently here</div>' : ''}
              <div class="room-box-icon">🏢</div>
              <div class="room-box-name">${facultyRoom.room_name}</div>
              <div class="room-box-description">${facultyRoom.description}</div>
            </div>
          `;
        }
        if (ciscoLab) {
          const isScanned = scannedRoomId && ciscoLab.id == scannedRoomId;
          html += `
            <div class="room-box ${isScanned ? 'room-box-scanned' : ''}" onclick="window.location.href='/room/${ciscoLab.id}';" style="cursor: pointer; position: relative;">
              ${isScanned ? '<div class="location-marker">📍 You are currently here</div>' : ''}
              <div class="room-box-icon">🏢</div>
              <div class="room-box-name">${ciscoLab.room_name}</div>
              <div class="room-box-description">${ciscoLab.description}</div>
            </div>
          `;
        }
        html += '</div>';

        html += '<div class="stairs-section"><span class="stairs-icon">⬆️</span> STAIRS FROM 2ND FLOOR</div>';
      }

      html += '</div>';
      floorPlanContainer.innerHTML = html;
    }

    // Setup floor selector buttons
    function setupFloorSelector() {
      const floorBtns = document.querySelectorAll('.floor-select-btn');
      floorBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
          e.preventDefault();
          const floor = parseInt(btn.getAttribute('data-floor'));
          
          // Update active button
          floorBtns.forEach(b => b.classList.remove('active'));
          btn.classList.add('active');
          
          // Update display
          document.getElementById('currentFloorDisplay').textContent = `Floor ${floor}`;
          
          // Render floor plan
          renderFloorPlan(floor);
        });
      });
    }

    // Load activity logs from the server
    async function loadActivityLogs() {
      try {
        const response = await fetch('/api/activity-logs', {
          credentials: 'include',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
          }
        });
        const result = await response.json();
        
        if (result.success && result.data.length > 0) {
          const activityLogBody = document.getElementById('activity-log-body');
          const noActivityMessage = document.getElementById('no-activity-message');
          
          activityLogBody.innerHTML = result.data.map(log => {
            const scanDateTime = new Date(log.scan_time).toLocaleString('en-US', {
              year: 'numeric',
              month: '2-digit',
              day: '2-digit',
              hour: '2-digit',
              minute: '2-digit',
              second: '2-digit',
              hour12: true
            });
            
            const statusBadgeClass = log.status.toLowerCase() === 'completed' ? 'done' : 'pending';
            const statusText = log.status.charAt(0).toUpperCase() + log.status.slice(1).toLowerCase();
            
            return `
              <tr>
                <td>${log.activity_description}</td>
                <td>${scanDateTime}</td>
                <td><span class="badge ${statusBadgeClass}">${statusText}</span></td>
              </tr>
            `;
          }).join('');
          
          noActivityMessage.style.display = 'none';
        } else {
          document.getElementById('no-activity-message').style.display = 'block';
          document.getElementById('activity-log-body').innerHTML = '';
        }
      } catch (error) {
        console.error('Error loading activity logs:', error);
      }
    }

    // Load rooms when page loads
    document.addEventListener('DOMContentLoaded', function() {
      console.log('Page loaded, loading rooms');
      
      // Check for scanned room data
      const urlParams = new URLSearchParams(window.location.search);
      if (urlParams.has('section') && urlParams.get('section') === 'map') {
        scannedRoomId = sessionStorage.getItem('scannedRoomId');
        scannedRoomFloor = sessionStorage.getItem('scannedRoomFloor');
        scannedRoomName = sessionStorage.getItem('scannedRoomName');
        
        if (scannedRoomId && scannedRoomFloor) {
          console.log('Scanned room detected:', scannedRoomName, 'Floor:', scannedRoomFloor);
          // Clear the session storage
          sessionStorage.removeItem('scannedRoomId');
          sessionStorage.removeItem('scannedRoomFloor');
          sessionStorage.removeItem('scannedRoomName');
        }
      }
      
      loadRooms().then(() => {
        setupFloorSelector();
        loadActivityLogs(); // Load activity logs
        
        // If we have a scanned room, navigate to the map section
        if (scannedRoomId && scannedRoomFloor) {
          navigateToSection('map');
        }
      });
    });
  </script>
</body>
</html>
