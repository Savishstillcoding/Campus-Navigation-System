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
      width: 100%;
      border-radius: 12px;
      display: none;
      background: #f1f5f9;
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
      <video id="scanner-video" autoplay playsinline></video>
      
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

    const startBtn = document.getElementById('start-scanner-btn');
    const submitBtn = document.getElementById('submit-btn');
    const qrInput = document.getElementById('qr-input');
    const statusDiv = document.getElementById('camera-status');

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
          
          showStatus('Camera started. Point at a QR code...');
          
          // Ensure video is playing
          video.play().then(() => {
            cameraActive = true;
            startBtn.textContent = 'Stop Camera';
            
            // Small delay to ensure video is loaded
            setTimeout(() => {
              scanQRCodeFromCamera();
            }, 500);
          }).catch(err => {
            showStatus('Error playing video: ' + err.message);
          });

        } catch (err) {
          showStatus('Camera Error: ' + err.message);
          console.error('Camera error:', err);
          alert('Unable to access camera:\n' + err.message + '\n\nPlease check your browser permissions and try again.');
        }
      } else {
        // Stop camera
        if (stream) {
          stream.getTracks().forEach(track => track.stop());
        }
        video.style.display = 'none';
        cameraActive = false;
        startBtn.textContent = 'Start Camera';
        hideStatus();
      }
    });

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
            if (stream) {
              stream.getTracks().forEach(track => track.stop());
            }
            video.style.display = 'none';
            cameraActive = false;
            startBtn.textContent = 'Start Camera';
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
      `;
      
      document.getElementById('room-info').innerHTML = roomHtml;
      resultDiv.style.display = 'block';
    }

    function displayError(message) {
      resultDiv.classList.remove('success');
      resultDiv.classList.add('error');
      document.getElementById('result-title').textContent = '✗ Error';
      document.getElementById('room-info').innerHTML = `<p style="color: #b91c1c;">${message}</p>`;
      resultDiv.style.display = 'block';
    }

    function scanQRCodeFromCamera() {
      if (!cameraActive) return;

      // Check if video has loaded and has valid dimensions
      if (video.videoWidth === 0 || video.videoHeight === 0) {
        requestAnimationFrame(scanQRCodeFromCamera);
        return;
      }

      try {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

        const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
        const code = jsQR(imageData.data, imageData.width, imageData.height);

        if (code) {
          qrInput.value = code.data;
          scanQRCode(code.data);
        } else {
          requestAnimationFrame(scanQRCodeFromCamera);
        }
      } catch (err) {
        console.error('QR scan error:', err);) {
        qrInput.value = code.data;
        scanQRCode(code.data);
      } else {
        requestAnimationFrame(scanQRCodeFromCamera);
      }
    }

    // Add CSRF token meta tag if not present
    if (!document.querySelector('meta[name="csrf-token"]')) {
      const meta = document.createElement('meta');
      meta.name = 'csrf-token';
      meta.content = '{{ csrf_token() }}';
      document.head.appendChild(meta);
    }
  </script>
</body>
</html>
