<?php
// Terra Real Estate - Maintenance Page
$launch_date = strtotime('2025-04-15 00:00:00');
$now = time();
$diff = $launch_date - $now;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Terra Real Estate — Coming Soon</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Barlow:wght@300;400;500&display=swap" rel="stylesheet">

  <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

    :root {
      --navy:   #1a2d5a;
      --orange: #d4601a;
      --cream:  #f7f3ee;
      --white:  #ffffff;
      --gold:   #c9a96e;
    }

    html, body {
      height: 100%;
      font-family: 'Barlow', sans-serif;
      background: var(--cream);
      color: var(--navy);
      overflow-x: hidden;
    }

    /* ── NOISE TEXTURE OVERLAY ── */
    body::before {
      content: '';
      position: fixed; inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='.04'/%3E%3C/svg%3E");
      pointer-events: none;
      z-index: 0;
    }

    /* ── GEOMETRIC BG SHAPES ── */
    .bg-shape {
      position: fixed;
      border-radius: 50%;
      filter: blur(80px);
      opacity: .12;
      z-index: 0;
    }
    .bg-shape-1 {
      width: 600px; height: 600px;
      background: var(--navy);
      top: -200px; right: -150px;
    }
    .bg-shape-2 {
      width: 400px; height: 400px;
      background: var(--orange);
      bottom: -100px; left: -100px;
    }
    .bg-shape-3 {
      width: 250px; height: 250px;
      background: var(--gold);
      top: 50%; left: 60%;
    }

    /* ── DIAGONAL ACCENT BAR ── */
    .diagonal-bar {
      position: fixed;
      top: 0; right: 0;
      width: 45%;
      height: 100vh;
      background: linear-gradient(160deg, var(--navy) 0%, #0f1e3d 100%);
      clip-path: polygon(18% 0, 100% 0, 100% 100%, 0% 100%);
      z-index: 1;
    }
    .diagonal-bar::after {
      content: '';
      position: absolute; inset: 0;
      background: repeating-linear-gradient(
        45deg,
        transparent,
        transparent 40px,
        rgba(255,255,255,.02) 40px,
        rgba(255,255,255,.02) 80px
      );
    }

    /* ── MAIN LAYOUT ── */
    .wrapper {
      position: relative;
      z-index: 10;
      min-height: 100vh;
      display: grid;
      grid-template-columns: 1fr 1fr;
    }

    /* ── LEFT PANEL ── */
    .left {
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 60px 70px 60px 80px;
      animation: slideInLeft .9s cubic-bezier(.22,1,.36,1) both;
    }

    @keyframes slideInLeft {
      from { opacity: 0; transform: translateX(-40px); }
      to   { opacity: 1; transform: translateX(0); }
    }

    /* ── LOGO ── */
    .logo-wrap {
      margin-bottom: 48px;
    }
    .logo-wrap img {
      width: 260px;
      height: auto;
      filter: drop-shadow(0 4px 16px rgba(26,45,90,.15));
    }

    /* ── BADGE ── */
    .badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(212,96,26,.1);
      border: 1px solid rgba(212,96,26,.3);
      color: var(--orange);
      font-size: .72rem;
      font-weight: 500;
      letter-spacing: .14em;
      text-transform: uppercase;
      padding: 6px 16px;
      border-radius: 100px;
      margin-bottom: 28px;
    }
    .badge .dot {
      width: 6px; height: 6px;
      border-radius: 50%;
      background: var(--orange);
      animation: pulse 1.6s ease-in-out infinite;
    }
    @keyframes pulse {
      0%,100% { opacity: 1; transform: scale(1); }
      50%      { opacity: .4; transform: scale(1.4); }
    }

    /* ── HEADLINE ── */
    h1 {
      font-family: 'Playfair Display', serif;
      font-size: clamp(2.8rem, 4.5vw, 4.2rem);
      font-weight: 900;
      line-height: 1.06;
      color: var(--navy);
      margin-bottom: 24px;
    }
    h1 em {
      font-style: normal;
      color: var(--orange);
      position: relative;
    }
    h1 em::after {
      content: '';
      position: absolute;
      bottom: 2px; left: 0; right: 0;
      height: 3px;
      background: var(--orange);
      border-radius: 2px;
      opacity: .4;
    }

    /* ── SUBTEXT ── */
    .sub {
      font-size: 1.05rem;
      font-weight: 300;
      line-height: 1.75;
      color: #4a5a7a;
      max-width: 400px;
      margin-bottom: 48px;
    }

    /* ── DIVIDER ── */
    .divider {
      width: 60px;
      height: 3px;
      background: linear-gradient(90deg, var(--orange), var(--gold));
      border-radius: 2px;
      margin-bottom: 48px;
    }

    /* ── COUNTDOWN ── */
    .countdown-label {
      font-size: .72rem;
      font-weight: 500;
      letter-spacing: .14em;
      text-transform: uppercase;
      color: #8090aa;
      margin-bottom: 18px;
    }

    .countdown {
      display: flex;
      gap: 20px;
      margin-bottom: 52px;
    }
    .count-block {
      text-align: center;
    }
    .count-num {
      font-family: 'Playfair Display', serif;
      font-size: 3rem;
      font-weight: 700;
      color: var(--navy);
      line-height: 1;
      min-width: 68px;
      display: block;
    }
    .count-sep {
      font-family: 'Playfair Display', serif;
      font-size: 2.6rem;
      color: var(--orange);
      align-self: flex-start;
      padding-top: 2px;
      opacity: .5;
    }
    .count-unit {
      font-size: .65rem;
      letter-spacing: .12em;
      text-transform: uppercase;
      color: #8090aa;
      margin-top: 6px;
      display: block;
    }

    /* ── NOTIFY FORM ── */
    .notify-label {
      font-size: .72rem;
      font-weight: 500;
      letter-spacing: .14em;
      text-transform: uppercase;
      color: #8090aa;
      margin-bottom: 12px;
    }
    .notify-form {
      display: flex;
      gap: 0;
      max-width: 420px;
    }
    .notify-form input {
      flex: 1;
      padding: 14px 20px;
      border: 1.5px solid #d8dde8;
      border-right: none;
      border-radius: 8px 0 0 8px;
      font-family: 'Barlow', sans-serif;
      font-size: .95rem;
      color: var(--navy);
      background: rgba(255,255,255,.7);
      outline: none;
      transition: border-color .2s;
    }
    .notify-form input:focus { border-color: var(--orange); }
    .notify-form input::placeholder { color: #aab0c0; }
    .notify-form button {
      padding: 14px 24px;
      background: var(--orange);
      color: #fff;
      border: none;
      border-radius: 0 8px 8px 0;
      font-family: 'Barlow', sans-serif;
      font-size: .9rem;
      font-weight: 500;
      letter-spacing: .04em;
      cursor: pointer;
      transition: background .2s, transform .1s;
      white-space: nowrap;
    }
    .notify-form button:hover { background: #b84e10; }
    .notify-form button:active { transform: scale(.97); }

    .success-msg {
      display: none;
      margin-top: 12px;
      font-size: .88rem;
      color: #2d7a4f;
      font-weight: 500;
    }

    /* ── RIGHT PANEL ── */
    .right {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 60px 60px 60px 80px;
      animation: slideInRight 1s cubic-bezier(.22,1,.36,1) .15s both;
    }

    @keyframes slideInRight {
      from { opacity: 0; transform: translateX(40px); }
      to   { opacity: 1; transform: translateX(0); }
    }

    /* ── ILLUSTRATION CARD ── */
    .card {
      background: rgba(255,255,255,.08);
      border: 1px solid rgba(255,255,255,.14);
      border-radius: 24px;
      padding: 48px 40px;
      text-align: center;
      backdrop-filter: blur(8px);
      width: 100%;
      max-width: 360px;
    }

    /* ── HOUSE SVG ICON ── */
    .house-icon {
      width: 120px;
      height: 120px;
      margin: 0 auto 28px;
    }

    /* ── GEAR ANIMATION ── */
    .gears {
      margin: 0 auto 32px;
      position: relative;
      width: 110px; height: 110px;
    }
    .gear {
      position: absolute;
      fill: none;
      stroke-width: 5;
    }
    .gear-outer {
      stroke: rgba(255,255,255,.7);
      animation: spinCW 6s linear infinite;
      transform-origin: 55px 55px;
    }
    .gear-inner {
      stroke: var(--orange);
      animation: spinCCW 3s linear infinite;
      transform-origin: 55px 55px;
    }
    @keyframes spinCW  { to { transform: rotate(360deg); } }
    @keyframes spinCCW { to { transform: rotate(-360deg); } }

    .card-title {
      font-family: 'Playfair Display', serif;
      font-size: 1.5rem;
      font-weight: 700;
      color: #fff;
      margin-bottom: 12px;
    }
    .card-body {
      font-size: .88rem;
      color: rgba(255,255,255,.6);
      line-height: 1.7;
      margin-bottom: 32px;
    }

    /* ── STATUS ITEMS ── */
    .status-list {
      list-style: none;
      width: 100%;
      text-align: left;
    }
    .status-list li {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 0;
      border-bottom: 1px solid rgba(255,255,255,.08);
      font-size: .82rem;
      color: rgba(255,255,255,.55);
    }
    .status-list li:last-child { border-bottom: none; }
    .status-icon {
      width: 20px; height: 20px;
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-size: .65rem;
      flex-shrink: 0;
    }
    .done  { background: rgba(45,170,90,.2); color: #5ddc8a; }
    .prog  { background: rgba(212,96,26,.2); color: var(--orange); }
    .wait  { background: rgba(255,255,255,.08); color: rgba(255,255,255,.3); }

    /* ── PROGRESS BAR ── */
    .progress-wrap {
      width: 100%;
      margin-top: 28px;
    }
    .progress-top {
      display: flex;
      justify-content: space-between;
      font-size: .72rem;
      color: rgba(255,255,255,.4);
      margin-bottom: 8px;
      letter-spacing: .06em;
    }
    .progress-track {
      height: 6px;
      background: rgba(255,255,255,.1);
      border-radius: 10px;
      overflow: hidden;
    }
    .progress-fill {
      height: 100%;
      width: 65%;
      background: linear-gradient(90deg, var(--orange), var(--gold));
      border-radius: 10px;
      animation: fillBar 1.5s cubic-bezier(.22,1,.36,1) .5s both;
    }
    @keyframes fillBar {
      from { width: 0; }
      to   { width: 65%; }
    }

    /* ── FOOTER ── */
    .footer {
      position: fixed;
      bottom: 0; left: 0; right: 0;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 18px 80px;
      font-size: .75rem;
      color: #8090aa;
      z-index: 20;
      letter-spacing: .04em;
    }
    .footer a { color: var(--orange); text-decoration: none; }
    .footer a:hover { text-decoration: underline; }
    .social-links { display: flex; gap: 20px; }

    /* ── RESPONSIVE ── */
    @media (max-width: 900px) {
      .diagonal-bar { display: none; }
      .wrapper { grid-template-columns: 1fr; }
      .left { padding: 60px 36px 40px; }
      .right { padding: 0 36px 100px; }
      .right .card { background: var(--navy); }
      .footer { padding: 18px 36px; flex-direction: column; gap: 8px; }
    }
  </style>
</head>
<body>

  <!-- Background shapes -->
  <div class="bg-shape bg-shape-1"></div>
  <div class="bg-shape bg-shape-2"></div>
  <div class="bg-shape bg-shape-3"></div>
  <div class="diagonal-bar"></div>

  <div class="wrapper">

    <!-- ══ LEFT PANEL ══ -->
    <div class="left">

      <div class="logo-wrap">
        <img src="logo.png" alt="Terra Real Estate Logo" />
      </div>

      <div class="badge">
        <span class="dot"></span>
        Under Maintenance
      </div>

      <h1>We're Building<br>Something <em>Great</em></h1>

      <div class="divider"></div>

      <p class="sub">
        Our website is currently undergoing scheduled maintenance and upgrades.
        We'll be back shortly with a refreshed experience — better, faster, and ready to help you find your perfect property.
      </p>

      <div class="countdown-label">Estimated Launch</div>
      <div class="countdown" id="countdown">
        <div class="count-block">
          <span class="count-num" id="cd-days">--</span>
          <span class="count-unit">Days</span>
        </div>
        <span class="count-sep">:</span>
        <div class="count-block">
          <span class="count-num" id="cd-hours">--</span>
          <span class="count-unit">Hours</span>
        </div>
        <span class="count-sep">:</span>
        <div class="count-block">
          <span class="count-num" id="cd-mins">--</span>
          <span class="count-unit">Minutes</span>
        </div>
        <span class="count-sep">:</span>
        <div class="count-block">
          <span class="count-num" id="cd-secs">--</span>
          <span class="count-unit">Seconds</span>
        </div>
      </div>

      <div class="notify-label">Get notified when we launch</div>
      <div class="notify-form">
        <input type="email" id="email-input" placeholder="your@email.com" />
        <button onclick="handleNotify()">Notify Me</button>
      </div>
      <div class="success-msg" id="success-msg">✓ You're on the list! We'll be in touch soon.</div>

    </div>

    <!-- ══ RIGHT PANEL ══ -->
    <div class="right">
      <div class="card">

        <!-- Gear animation -->
        <div class="gears">
          <svg class="gear" width="110" height="110" viewBox="0 0 110 110">
            <!-- Outer gear teeth -->
            <circle class="gear-outer" cx="55" cy="55" r="42" stroke-dasharray="8 6"/>
            <circle cx="55" cy="55" r="30" fill="none" stroke="rgba(255,255,255,.15)" stroke-width="2"/>
          </svg>
          <svg class="gear" width="110" height="110" viewBox="0 0 110 110" style="position:absolute;top:0;left:0;">
            <circle class="gear-inner" cx="55" cy="55" r="20" stroke-dasharray="5 4"/>
            <circle cx="55" cy="55" r="8" fill="rgba(212,96,26,.6)" stroke="none"/>
          </svg>
          <!-- House icon in center -->
          <svg style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:34px;height:34px;" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.5z"/>
            <path d="M9 21V12h6v9"/>
          </svg>
        </div>

        <div class="card-title">Maintenance in Progress</div>
        <div class="card-body">
          Our team is hard at work improving your experience. Everything will be back online very soon.
        </div>

        <ul class="status-list">
          <li>
            <span class="status-icon done">✓</span>
            Database migration &amp; backup
          </li>
          <li>
            <span class="status-icon done">✓</span>
            Security patches applied
          </li>
          <li>
            <span class="status-icon prog" style="animation:pulse 1.6s ease-in-out infinite;">⟳</span>
            Property listings upgrade
          </li>
          <li>
            <span class="status-icon wait">○</span>
            Final QA &amp; testing
          </li>
          <li>
            <span class="status-icon wait">○</span>
            Go live!
          </li>
        </ul>

        <div class="progress-wrap">
          <div class="progress-top">
            <span>Overall progress</span>
            <span>65%</span>
          </div>
          <div class="progress-track">
            <div class="progress-fill"></div>
          </div>
        </div>

      </div>
    </div>

  </div>

  <!-- Footer -->
  <div class="footer">
    <span>© <?php echo date('Y'); ?> Terra Real Estate. All rights reserved.</span>
    <div class="social-links">
      <a href="mailto:info@terrarealestate.com">Contact Us</a>
      <a href="#">Privacy Policy</a>
    </div>
  </div>

  <script>
    // ── Countdown Timer ──
    const target = new Date("<?php echo date('Y-m-d\TH:i:s', $launch_date); ?>").getTime();

    function updateCountdown() {
      const now  = Date.now();
      const diff = Math.max(0, target - now);
      const d = Math.floor(diff / 86400000);
      const h = Math.floor((diff % 86400000) / 3600000);
      const m = Math.floor((diff % 3600000)  / 60000);
      const s = Math.floor((diff % 60000)    / 1000);
      document.getElementById('cd-days').textContent  = String(d).padStart(2,'0');
      document.getElementById('cd-hours').textContent = String(h).padStart(2,'0');
      document.getElementById('cd-mins').textContent  = String(m).padStart(2,'0');
      document.getElementById('cd-secs').textContent  = String(s).padStart(2,'0');
    }
    updateCountdown();
    setInterval(updateCountdown, 1000);

    // ── Notify form ──
    function handleNotify() {
      const input = document.getElementById('email-input');
      const msg   = document.getElementById('success-msg');
      if (!input.value || !input.value.includes('@')) {
        input.style.borderColor = '#e05252';
        setTimeout(() => input.style.borderColor = '', 1500);
        return;
      }
      msg.style.display = 'block';
      input.value = '';
      input.placeholder = 'Thank you!';
    }
  </script>
</body>
</html>
