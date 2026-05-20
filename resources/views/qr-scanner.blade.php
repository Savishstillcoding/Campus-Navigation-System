<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>QR Code Scanner - LNU Smart Nav</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jsQR/1.4.0/jsQR.js"></script>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
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

    #scanner-video {
      display: none;
    }

    .scanner-section {
      margin-bottom: 24px;
      position: relative;
    }

    .scanner-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: auto;
      border-radius: 12px;
      z-index: 10;
      pointer-events: none;
    }

    @keyframes scanLine {
      0% {
        top: 0%;
      }
      100% {
        top: 100%;
      }
    }

    .scan-indicator {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      width: 100%;
      height: 3px;
      background: linear-gradient(90deg, transparent, #ff6b6b, transparent);
      animation: scanLine 2s linear infinite;
      z-index: 11;
    }

    .scanner-placeholder {
      width: 100%;
      aspect-ratio: 1;
      background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 48px;
      color: #cbd5e1;
      margin-bottom: 16px;
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

    <div class="scanner-section">
      <div class="scanner-placeholder">📍</div>
      <video 
        id="scanner-video" 
        autoplay 
        playsinline 
        muted
        style="width: 100%; border-radius: 12px; display: none; background: #f1f5f9;">
      </video>
      <canvas id="scanner-canvas" style="display: none;"></canvas>
      
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

    <div id="camera-status" style="text-align: center; padding: 12px; margin-bottom: 16px; background: #fef3c7; border-radius: 8px; display: none; color: #92400e; font-size: 13px;"></div>
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
    let stream = null;
    let cameraActive = false;
    let scanningActive = false;
    let scanTimeout = null;

    const startBtn = document.getElementById('start-scanner-btn');
    const submitBtn = document.getElementById('submit-btn');
    const qrInput = document.getElementById('qr-input');
    const statusDiv = document.getElementById('camera-status');
    const video = document.getElementById('scanner-video');
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
        try {
          showStatus('Requesting camera access...');
          
          const constraints = {
            video: {
              facingMode: 'environment',
              width: { ideal: 1280 },
              height: { ideal: 720 }
            },
            audio: false
          };

          stream = await navigator.mediaDevices.getUserMedia(constraints);
          video.srcObject = stream;
          video.style.display = 'block';
          
          // Add scan indicator
          const indicator = document.createElement('div');
          indicator.id = 'scanner-scan-indicator';
          indicator.className = 'scan-indicator';
          video.parentElement.appendChild(indicator);
          
          showStatus('Camera started. Point at a QR code...');
          console.log('Camera stream started');
          
          // Wait for video to be ready
          const videoReadyHandler = () => {
            if (video.readyState === video.HAVE_ENOUGH_DATA) {
              video.removeEventListener('loadedmetadata', videoReadyHandler);
              console.log('Video metadata loaded. Dimensions:', video.videoWidth, 'x', video.videoHeight);
              cameraActive = true;
              scanningActive = true;
              startBtn.textContent = 'Stop Camera';
              scanQRCodeFromCamera();
            }
          };
          
          video.addEventListener('loadedmetadata', videoReadyHandler);
          
          // Fallback timeout in case loadedmetadata doesn't fire
          setTimeout(() => {
            if (!cameraActive && stream) {
              console.log('Fallback timeout triggered. Starting scan.');
              cameraActive = true;
              scanningActive = true;
              startBtn.textContent = 'Stop Camera';
              scanQRCodeFromCamera();
            }
          }, 2000);

        } catch (err) {
          showStatus('Camera Error: ' + err.message);
          console.error('Camera error:', err);
          alert('Unable to access camera:\n' + err.message + '\n\nPlease check your browser permissions and try again.');
        }
      } else {
        // Stop camera
        stopCamera();
      }
    });

    function stopCamera() {
      if (stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
      }
      if (scanTimeout) {
        clearTimeout(scanTimeout);
      }
      
      // Remove scan indicator
      const indicator = document.getElementById('scanner-scan-indicator');
      if (indicator) {
        indicator.remove();
      }
      
      video.style.display = 'none';
      cameraActive = false;
      scanningActive = false;
      startBtn.textContent = 'Start Camera';
      hideStatus();
      console.log('Camera stopped');
    }

    submitBtn.addEventListener('click', () => {
      if (qrInput.value.trim()) {
        scanQRCode(qrInput.value.trim());
      } else {
        showStatus('Please enter a QR code');
      }
    });

    function scanQRCode(manualCode = null) {
      const codeToScan = manualCode || qrInput.value;
      
      if (!codeToScan && !cameraActive) {
        showStatus('Please enter a QR code or start the camera');
        return;
      }

      loading.classList.add('active');
      hideStatus();

      fetch('/api/qr/scan', {
        method: 'POST',
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
          if (cameraActive) {
            stopCamera();
          }
        } else {
          displayError(data.message);
        }
      })
      .catch(err => {
        loading.classList.remove('active');
        displayError('Error: ' + err.message);
      });
    }

    function isImageDataValid(imageData) {
      // Check if image data contains actual content (not just noise/black frames)
      const data = imageData.data;
      let brightPixels = 0;
      let darkPixels = 0;
      
      // Sample every 4th pixel for performance
      for (let i = 0; i < data.length; i += 16) {
        const r = data[i];
        const g = data[i + 1];
        const b = data[i + 2];
        const brightness = (r + g + b) / 3;
        
        if (brightness > 200) brightPixels++;
        if (brightness < 50) darkPixels++;
      }
      
      // Must have a reasonable mix of light and dark areas (indicates a real image)
      const sampleCount = data.length / 16;
      const brightRatio = brightPixels / sampleCount;
      const darkRatio = darkPixels / sampleCount;
      
      // If more than 90% is uniform (all bright or all dark), it's likely corrupted
      return !(brightRatio > 0.9 || darkRatio > 0.9);
    }

    function scanQRCodeFromCamera() {
      if (!scanningActive) {
        console.log('Scanning stopped');
        return;
      }

      // Check if jsQR is available
      if (typeof jsQR === 'undefined') {
        console.error('jsQR library not loaded yet, retrying...');
        showStatus('Loading QR library... Please wait.');
        scanTimeout = setTimeout(scanQRCodeFromCamera, 500);
        return;
      }

      // Check if video has valid dimensions
      if (video.videoWidth === 0 || video.videoHeight === 0) {
        console.log('Video not ready (dimensions: 0x0), retrying...');
        scanTimeout = setTimeout(scanQRCodeFromCamera, 200);
        return;
      }

      try {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d', { willReadFrequently: true });
        
        if (!ctx) {
          console.error('Failed to get canvas context');
          scanTimeout = setTimeout(scanQRCodeFromCamera, 100);
          return;
        }
        
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        
        // Draw the current video frame to canvas
        try {
          ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        } catch (drawErr) {
          console.error('Error drawing video to canvas:', drawErr);
          scanTimeout = setTimeout(scanQRCodeFromCamera, 100);
          return;
        }
        
        // Get image data
        let imageData;
        try {
          imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
        } catch (imgErr) {
          console.error('Error getting image data:', imgErr);
          scanTimeout = setTimeout(scanQRCodeFromCamera, 100);
          return;
        }
        
        if (!imageData || !imageData.data) {
          console.error('Invalid image data');
          scanTimeout = setTimeout(scanQRCodeFromCamera, 100);
          return;
        }

        // Validate that the video frame is not corrupted
        if (!isImageDataValid(imageData)) {
          console.log('Video frame appears corrupted or uniformly colored, skipping QR detection');
          scanTimeout = setTimeout(scanQRCodeFromCamera, 100);
          return;
        }

        // Detect QR code
        let code = jsQR(imageData.data, imageData.width, imageData.height);
        
        if (code && code.data && code.data.length > 0) {
          console.log('✓ QR Code detected:', code.data);
          qrInput.value = code.data;
          scanningActive = false;
          scanQRCode(code.data);
          return;
        }

        // Continue scanning
        scanTimeout = setTimeout(scanQRCodeFromCamera, 100);
        
      } catch (err) {
        console.error('Unexpected QR scan error:', err.message);
        scanTimeout = setTimeout(scanQRCodeFromCamera, 100);
      }
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

    // Verify jsQR library is loaded
    document.addEventListener('DOMContentLoaded', () => {
      if (typeof jsQR === 'undefined') {
        console.warn('jsQR library not loaded, waiting...');
        setTimeout(() => {
          if (typeof jsQR !== 'undefined') {
            console.log('jsQR library loaded successfully');
          } else {
            console.error('jsQR library failed to load from CDN');
            showStatus('Warning: QR detection library may not be available. Manual entry is recommended.');
          }
        }, 1000);
      } else {
        console.log('jsQR library loaded successfully on page load');
      }
    });
  </script>
</body>
</html>
