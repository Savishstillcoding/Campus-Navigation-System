<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $room->room_name }} - LNU Smart Nav</title>
  <script async src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
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
      padding: 20px;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
    }

    .header {
      display: flex;
      align-items: center;
      margin-bottom: 30px;
      gap: 15px;
    }

    .back-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 45px;
      height: 45px;
      background: white;
      border: none;
      border-radius: 50%;
      cursor: pointer;
      font-size: 20px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      transition: all 0.3s ease;
    }

    .back-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
    }

    .header-content h1 {
      color: white;
      font-size: 32px;
      margin-bottom: 5px;
    }

    .header-content p {
      color: rgba(255, 255, 255, 0.8);
      font-size: 16px;
    }

    .card {
      background: white;
      border-radius: 16px;
      padding: 32px;
      margin-bottom: 24px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    .qr-section {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 32px;
      background: linear-gradient(135deg, #f0f5ff 0%, #f5f0ff 100%);
      border-radius: 16px;
      margin-bottom: 24px;
    }

    .qr-container {
      background: white;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
      margin-bottom: 16px;
    }

    #qrcode {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .qr-label {
      text-align: center;
      margin-bottom: 16px;
    }

    .qr-label h3 {
      color: #1e293b;
      font-size: 18px;
      margin-bottom: 8px;
    }

    .qr-label p {
      color: #64748b;
      font-size: 14px;
    }

    .qr-code-value {
      background: #f1f5f9;
      padding: 12px 16px;
      border-radius: 8px;
      font-family: 'Courier New', monospace;
      font-size: 14px;
      color: #1e293b;
      word-break: break-all;
      text-align: center;
      margin-top: 16px;
      border: 2px solid #e2e8f0;
    }

    .room-details {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 24px;
    }

    .detail-group {
      padding: 20px;
      background: #f8fafc;
      border-radius: 12px;
      border-left: 4px solid #667eea;
    }

    .detail-label {
      font-size: 12px;
      font-weight: 700;
      text-transform: uppercase;
      color: #64748b;
      margin-bottom: 8px;
      letter-spacing: 0.5px;
    }

    .detail-value {
      font-size: 18px;
      font-weight: 600;
      color: #1e293b;
    }

    .description-section {
      padding: 24px;
      background: #f0fdf4;
      border-radius: 12px;
      border-left: 4px solid #22c55e;
      margin-top: 24px;
    }

    .description-section h3 {
      color: #166534;
      font-size: 16px;
      margin-bottom: 12px;
    }

    .description-section p {
      color: #166534;
      line-height: 1.6;
    }

    .actions {
      display: flex;
      gap: 12px;
      margin-top: 24px;
      flex-wrap: wrap;
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
      flex: 1;
      min-width: 150px;
    }

    .btn-primary:hover {
      background: #5568d3;
      transform: translateY(-2px);
      box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
    }

    .btn-secondary {
      background: #e2e8f0;
      color: #1e293b;
      flex: 1;
      min-width: 150px;
    }

    .btn-secondary:hover {
      background: #cbd5e1;
      transform: translateY(-2px);
    }

    .info-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 16px;
    }

    .qr-loading {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 300px;
      color: #667eea;
      font-weight: 600;
    }

    .qr-loading-spinner {
      border: 4px solid #e2e8f0;
      border-top: 4px solid #667eea;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      animation: spin 1s linear infinite;
      margin-right: 12px;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    @media (max-width: 640px) {
      .card {
        padding: 20px;
      }

      .header-content h1 {
        font-size: 24px;
      }

      .qr-section {
        padding: 20px;
      }

      .room-details {
        grid-template-columns: 1fr;
      }

      .info-grid {
        grid-template-columns: 1fr;
      }

      .actions {
        flex-direction: column;
      }

      .btn {
        width: 100%;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Header -->
    <div class="header">
      <button class="back-btn" onclick="window.history.back();">←</button>
      <div class="header-content">
        <h1>{{ $room->room_name }}</h1>
        <p>Room Details & QR Code</p>
      </div>
    </div>

    <!-- QR Code Section -->
    <div class="qr-section">
      <div class="qr-label">
        <h3>📱 Scan This QR Code</h3>
        <p>Use your device to scan the QR code below</p>
      </div>

      <div class="qr-container">
        <div class="qr-loading" id="qr-loading">
          <div class="qr-loading-spinner"></div>
          <span>Generating QR Code...</span>
        </div>
        <div id="qrcode" style="display: none;"></div>
      </div>

      <div class="qr-code-value">
        {{ $room->qr_code }}
      </div>
    </div>

    <!-- Room Details Card -->
    <div class="card">
      <h2 style="margin-bottom: 24px; color: #1e293b;">Room Information</h2>

      <div class="info-grid">
        <div class="detail-group">
          <div class="detail-label">🏢 Room Name</div>
          <div class="detail-value">{{ $room->room_name }}</div>
        </div>

        <div class="detail-group">
          <div class="detail-label">🔢 Room Number</div>
          <div class="detail-value">{{ $room->room_number }}</div>
        </div>

        <div class="detail-group">
          <div class="detail-label">📍 Floor</div>
          <div class="detail-value">Floor {{ $room->floor }}</div>
        </div>

        <div class="detail-group">
          <div class="detail-label">🏛️ Building</div>
          <div class="detail-value">{{ $room->building }}</div>
        </div>
      </div>

      @if($room->location)
        <div class="detail-group" style="margin-top: 16px; grid-column: 1 / -1;">
          <div class="detail-label">📌 Location</div>
          <div class="detail-value">{{ $room->location }}</div>
        </div>
      @endif

      @if($room->description)
        <div class="description-section">
          <h3>Description</h3>
          <p>{{ $room->description }}</p>
        </div>
      @endif

      <!-- Actions -->
      <div class="actions">
        <button class="btn btn-primary" onclick="downloadQRCode();">
          📥 Download QR Code
        </button>
        <button class="btn btn-secondary" onclick="window.location.href='{{ route('qr-scanner') }}';">
          📱 Use Scanner
        </button>
      </div>
    </div>
  </div>

  <script>
    let qrCodeGenerated = false;

    // Wait for DOM and QRCode library to be ready
    function initQRCode() {
      if (typeof QRCode === 'undefined') {
        // Library not loaded yet, retry
        setTimeout(initQRCode, 100);
        return;
      }

      const qrContainer = document.getElementById('qrcode');
      const loadingIndicator = document.getElementById('qr-loading');

      if (!qrContainer) {
        console.error('QR code container not found');
        return;
      }

      try {
        // Generate QR code
        const qrCode = new QRCode(qrContainer, {
          text: '{{ $room->qr_code }}',
          width: 300,
          height: 300,
          colorDark: '#1e293b',
          colorLight: '#ffffff',
          correctLevel: QRCode.CorrectLevel.H
        });

        // Hide loading and show QR code
        if (loadingIndicator) {
          loadingIndicator.style.display = 'none';
        }
        qrContainer.style.display = 'block';
        qrCodeGenerated = true;
      } catch (error) {
        console.error('Error generating QR code:', error);
        if (loadingIndicator) {
          loadingIndicator.innerHTML = '<span style="color: #b91c1c;">⚠️ Failed to load QR code. Please refresh the page.</span>';
        }
      }
    }

    // Download QR Code function
    function downloadQRCode() {
      if (!qrCodeGenerated) {
        alert('QR code is still loading. Please wait a moment and try again.');
        return;
      }

      const canvas = document.querySelector('#qrcode canvas');
      if (!canvas) {
        alert('QR code is not ready. Please refresh the page.');
        return;
      }

      try {
        const roomName = document.querySelector('.detail-value')?.textContent?.trim() || 'room';
        const link = document.createElement('a');
        link.href = canvas.toDataURL('image/png');
        link.download = `${roomName}-qr-code.png`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
      } catch (error) {
        console.error('Error downloading QR code:', error);
        alert('Error downloading QR code. Please try again.');
      }
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', initQRCode);
    } else {
      initQRCode();
    }
  </script>
</body>
</html>
