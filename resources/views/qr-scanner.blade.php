<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=no">
  <meta name="apple-mobile-web-app-capable" content="true">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <title>QR Code Scanner - LNU Smart Nav</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.4/html5-qrcode.min.js"></script>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html, body {
      width: 100%;
      overflow-x: hidden;
    }

    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      min-height: 100dvh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      padding: max(20px, env(safe-area-inset-top)) max(20px, env(safe-area-inset-right)) max(20px, env(safe-area-inset-bottom)) max(20px, env(safe-area-inset-left));
      -webkit-user-select: none;
      user-select: none;
    }

    .container {
      background: white;
      border-radius: 16px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
      max-width: 500px;
      width: 100%;
      padding: 32px;
    }

    .header {
      text-align: center;
      margin-bottom: 32px;
    }

    .header h1 {
      font-size: 28px;
      color: #1e293b;
      margin-bottom: 8px;
    }

    .header p {
      color: #64748b;
      font-size: 14px;
    }

    .scanner-section {
      margin-bottom: 24px;
    }

    #qr-reader {
      width: 100%;
      margin-bottom: 16px;
    }

    #qr-reader video {
      width: 100%;
      border-radius: 12px;
    }

    .input-group {
      display: flex;
      gap: 8px;
      margin-bottom: 16px;
    }

    #qr-input {
      flex: 1;
      padding: 12px 16px;
      border: 2px solid #e2e8f0;
      border-radius: 8px;
      font-size: 14px;
      transition: border-color 0.2s;
    }

    #qr-input:focus {
      outline: none;
      border-color: #667eea;
    }

    .btn {
      padding: 12px 24px;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s;
      font-size: 14px;
    }

    .btn-primary {
      background: #667eea;
      color: white;
    }

    .btn-primary:hover {
      background: #5568d3;
      transform: translateY(-2px);
    }

    .btn-primary:disabled {
      background: #cbd5e1;
      cursor: not-allowed;
      transform: none;
    }

    .btn-secondary {
      background: #f1f5f9;
      color: #1e293b;
    }

    .btn-secondary:hover {
      background: #e2e8f0;
    }

    .button-group {
      display: flex;
      gap: 8px;
    }

    .button-group button {
      flex: 1;
    }

    .result-section {
      display: none;
      padding: 20px;
      background: #f0fdf4;
      border: 2px solid #86efac;
      border-radius: 12px;
      margin-bottom: 16px;
    }

    .result-section.error {
      background: #fef2f2;
      border-color: #fca5a5;
    }

    .result-section.success {
      background: #f0fdf4;
      border-color: #86efac;
    }

    .result-title {
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 12px;
      color: #15803d;
    }

    .result-section.error .result-title {
      color: #b91c1c;
    }

    .room-info {
      display: grid;
      gap: 12px;
    }

    .info-item {
      display: flex;
      justify-content: space-between;
      padding: 8px 0;
      border-bottom: 1px solid rgba(21, 128, 61, 0.1);
    }

    .info-label {
      font-weight: 600;
      color: #15803d;
    }

    .info-value {
      color: #166534;
    }

    .result-section.error .info-label,
    .result-section.error .info-value {
      color: #b91c1c;
    }

    .loading {
      display: none;
      text-align: center;
      padding: 16px;
    }

    .spinner {
      border: 4px solid #e2e8f0;
      border-top: 4px solid #667eea;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      animation: spin 1s linear infinite;
      margin: 0 auto 12px;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    .loading.active {
      display: block;
    }

    .info-item:last-child {
      border-bottom: none;
    }

    .nav-to-map-btn {
      width: 100%;
      padding: 12px 16px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
      font-size: 14px;
    }

    .nav-to-map-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 16px rgba(102, 126, 234, 0.4);
    }

    .nav-to-map-btn:active {
      transform: translateY(0);
    }

    #camera-status {
      text-align: center;
      padding: 12px;
      margin-bottom: 16px;
      background: #fef3c7;
      border-radius: 8px;
      display: none;
      color: #92400e;
      font-size: 13px;
    }

    @media (max-width: 480px) {
      .container {
        padding: 20px;
      }

      .header h1 {
        font-size: 24px;
      }

      .button-group {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>📱 QR Scanner</h1>
      <p>Scan a QR code to find your room</p>
    </div>

    <div id="camera-status"></div>

    <div class="scanner-section">
      <div id="qr-reader" style="width: 100%;"></div>
      
      <div class="input-group">
        <input 
          type="text" 
          id="qr-input" 
          placeholder="Or enter QR code manually..." 
          autocomplete="off"
        >
      </div>

      <div class="button-group">
        <button class="btn btn-primary" id="start-scanner-btn">Start Camera</button>
        <button class="btn btn-secondary" id="submit-btn">Submit</button>
      </div>
    </div>

    <div class="loading" id="loading">
      <div class="spinner"></div>
      <p>Scanning...</p>
    </div>

    <div class="result-section" id="result">
      <div class="result-title" id="result-title"></div>
      <div class="room-info" id="room-info"></div>
    </div>
  </div>

  <script>
    let html5QrcodeScanner = null;
    let cameraActive = false;
    let lastScannedCode = null;
    let scanCooldown = false;

    const startBtn = document.getElementById('start-scanner-btn');
    const submitBtn = document.getElementById('submit-btn');
    const qrInput = document.getElementById('qr-input');
    const statusDiv = document.getElementById('camera-status');
    const loading = document.getElementById('loading');
    const resultDiv = document.getElementById('result');

    function showStatus(message) {
      statusDiv.textContent = message;
      statusDiv.style.display = 'block';
    }

    function hideStatus() {
      statusDiv.style.display = 'none';
    }

    startBtn.addEventListener('click', async () => {
      if (!cameraActive) {
        startScanner();
      } else {
        stopScanner();
      }
    });

    function startScanner() {
      try {
        showStatus('Initializing camera...');
        
        html5QrcodeScanner = new Html5Qrcode('qr-reader');
        
        const qrboxFunction = () => {
          let minDimensionPx = Math.min(window.innerWidth, window.innerHeight);
          let qrboxsize = Math.floor(minDimensionPx * 0.8);
          return { width: qrboxsize, height: qrboxsize };
        };

        const config = {
          fps: 10,
          qrbox: qrboxFunction,
          rememberLastUsedCamera: true,
          supportedScanTypes: [Html5QrcodeScanType.CAMERA],
          useBarCodeDetectorIfSupported: true
        };

        html5QrcodeScanner.start(
          { facingMode: 'environment' },
          config,
          onScanSuccess,
          onScanFailure
        ).then(() => {
          cameraActive = true;
          startBtn.textContent = 'Stop Camera';
          showStatus('Camera active. Point at a QR code...');
          console.log('✓ Camera started successfully');
        }).catch(err => {
          console.error('Camera start error:', err);
          showStatus('Camera Error: ' + err.message);
          alert('Unable to access camera:\n' + err.message + '\n\nPlease check your browser permissions and try again.');
        });

      } catch (err) {
        showStatus('Camera Error: ' + err.message);
        console.error('Scanner error:', err);
        alert('Error initializing scanner:\n' + err.message);
      }
    }

    function stopScanner() {
      if (html5QrcodeScanner) {
        html5QrcodeScanner.stop().then(() => {
          cameraActive = false;
          startBtn.textContent = 'Start Camera';
          hideStatus();
          console.log('Camera stopped');
        }).catch(err => {
          console.error('Error stopping scanner:', err);
        });
      }
    }

    function onScanSuccess(decodedText, decodedResult) {
      // Prevent duplicate scans
      if (scanCooldown || lastScannedCode === decodedText) {
        return;
      }

      scanCooldown = true;
      lastScannedCode = decodedText;

      console.log('✓ QR Code detected:', decodedText);
      qrInput.value = decodedText;
      stopScanner();
      scanQRCode(decodedText);

      // Cooldown to prevent rapid re-scanning
      setTimeout(() => {
        scanCooldown = false;
      }, 2000);
    }

    function onScanFailure(error) {
      // Silent failure - just continue scanning
      // console.debug('QR scan attempt:', error);
    }

    submitBtn.addEventListener('click', () => {
      if (qrInput.value.trim()) {
        if (cameraActive) {
          stopScanner();
        }
        scanQRCode(qrInput.value.trim());
      } else {
        showStatus('Please enter a QR code');
      }
    });

    function scanQRCode(codeToScan) {
      if (!codeToScan) {
        showStatus('Please enter a QR code or start the camera');
        return;
      }

      loading.classList.add('active');
      hideStatus();

      fetch('/api/qr/scan', {
        method: 'POST',
        credentials: 'include',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
        },
        body: JSON.stringify({ 
          qr_code: codeToScan 
        }),
      })
      .then(response => response.json())
      .then(data => {
        loading.classList.remove('active');
        
        if (data.success) {
          displayRoomInfo(data.data);
        } else {
          displayError(data.message);
        }
      })
      .catch(err => {
        loading.classList.remove('active');
        displayError('Error: ' + err.message);
      });
    }

    function displayRoomInfo(room) {
      resultDiv.classList.remove('error');
      resultDiv.classList.add('success');
      document.getElementById('result-title').textContent = '✓ Room Found!';
      
      const roomHtml = `
        <div class="info-item">
          <span class="info-label">Room Name:</span>
          <span class="info-value">${room.room_name}</span>
        </div>
        <div class="info-item">
          <span class="info-label">Room Number:</span>
          <span class="info-value">${room.room_number}</span>
        </div>
        <div class="info-item">
          <span class="info-label">Floor:</span>
          <span class="info-value">${room.floor}</span>
        </div>
        <div class="info-item">
          <span class="info-label">Building:</span>
          <span class="info-value">${room.building}</span>
        </div>
        ${room.description ? `
        <div class="info-item">
          <span class="info-label">Description:</span>
          <span class="info-value">${room.description}</span>
        </div>
        ` : ''}
        <div class="info-item" style="margin-top: 16px; padding-top: 16px; border-top: 2px solid rgba(21, 128, 61, 0.2);">
          <button class="nav-to-map-btn" onclick="redirectToMap('${room.id}', '${room.floor}', '${room.room_name}')">
            🗺️ View on Map
          </button>
        </div>
      `;
      
      document.getElementById('room-info').innerHTML = roomHtml;
      resultDiv.style.display = 'block';
    }

    function redirectToMap(roomId, floor, roomName) {
      // Store the scanned room data in sessionStorage so the map can access it
      sessionStorage.setItem('scannedRoomId', roomId);
      sessionStorage.setItem('scannedRoomFloor', floor);
      sessionStorage.setItem('scannedRoomName', roomName);
      
      // Redirect to the main portal's map section
      window.location.href = '/main?section=map';
    }

    function displayError(message) {
      resultDiv.classList.remove('success');
      resultDiv.classList.add('error');
      document.getElementById('result-title').textContent = '✗ Error';
      document.getElementById('room-info').innerHTML = `<p style="color: #b91c1c;">${message}</p>`;
      resultDiv.style.display = 'block';
    }

    // Add CSRF token meta tag if not present
    if (!document.querySelector('meta[name="csrf-token"]')) {
      const meta = document.createElement('meta');
      meta.name = 'csrf-token';
      meta.content = '{{ csrf_token() }}';
      document.head.appendChild(meta);
    }

    // Cleanup on page unload
    window.addEventListener('beforeunload', () => {
      if (cameraActive && html5QrcodeScanner) {
        html5QrcodeScanner.stop().catch(err => console.error('Cleanup error:', err));
      }
    });
  </script>
</body>
</html>
