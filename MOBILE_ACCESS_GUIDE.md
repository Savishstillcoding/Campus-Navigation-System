# Mobile Access Setup Guide

## Your Network Details
- **Local IP Address**: 10.10.217.7
- **Laravel Port**: 8000
- **Local URL**: http://localhost:8000
- **Mobile URL**: http://10.10.217.7:8000

---

## Option 1: Direct Network Access (Recommended - No Setup Required)

### For Devices on Same WiFi Network:

1. Make sure your phone and computer are on the **same WiFi network**
2. Open your phone's browser
3. Go to: **http://10.10.217.7:8000**

### Troubleshooting if it doesn't work:
- Ensure Laravel dev server is running on port 8000
- Check that your phone and computer can ping each other
- Disable Windows Firewall temporarily or add port 8000 to firewall rules

---

## Option 2: Using ngrok (For Remote Testing)

ngrok is already partially set up on your system (port 4040 is listening).

### If ngrok tunnel is active:
1. Open your browser on your phone
2. Visit the public ngrok URL (should appear in your terminal where ngrok started)
3. Format is typically: `https://xxxxx-xx-xxx-xxx-xx.ngrok.io`

### To manually start a new ngrok tunnel:

**Via Command Line (if ngrok is installed but not in PATH):**
```powershell
# Find and run ngrok directly
& "C:\Program Files\ngrok\ngrok.exe" http 8000
```

**Or add to PATH and use:**
```powershell
ngrok http 8000
```

### If ngrok is NOT installed:
You can download it from: https://ngrok.com/download

---

## Step-by-Step: Starting Fresh with ngrok

1. **Stop current Laravel server** (if needed):
   ```powershell
   # Kill PHP processes
   Stop-Process -Name php -Force
   ```

2. **Start Laravel on all interfaces**:
   ```powershell
   cd "C:\Users\Nickole\OneDrive\Desktop\CAMPUS NAV\Campus-Navigation-System"
   php artisan serve --host=0.0.0.0 --port=8000
   ```

3. **Start ngrok tunnel** (in another terminal):
   ```powershell
   ngrok http 8000
   ```

4. **Copy the ngrok URL** from the terminal output (it looks like: `https://xxx.ngrok.io`)

5. **Access on your phone** using that URL

---

## Issues & Solutions

### "Connection refused" or "Can't reach server"
- [ ] Laravel server not running? Start it with: `php artisan serve --host=0.0.0.0`
- [ ] Firewall blocking? Add exception for port 8000
- [ ] Different network? Use ngrok instead

### "ngrok not recognized"
- [ ] Download from https://ngrok.com/download
- [ ] Extract to `C:\Program Files\ngrok`
- [ ] Add to PATH or run full path: `C:\Program Files\ngrok\ngrok.exe http 8000`

### "ngrok tunnel not working"
- [ ] Need ngrok account? Sign up at https://ngrok.com (free)
- [ ] Run: `ngrok config add-authtoken YOUR_AUTH_TOKEN`
- [ ] Restart ngrok

---

## Testing the Connection

Once you have the URL (either `http://10.10.217.7:8000` or the ngrok URL):

1. Open the URL on your phone
2. You should see the Campus Navigation System home page
3. Test the QR scanner and room details features

---

## Notes
- **Local network access** (10.10.217.7:8000) works on the same WiFi - fastest option
- **ngrok** is needed if testing from outside your network or on different WiFi
- Make sure to test all features: login, QR scanner, room directory, and details page
