<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Terra Login Credentials</title>
<style>
  body      { margin:0; padding:0; background:#F7F5F2; font-family:'Helvetica Neue',Helvetica,Arial,sans-serif; color:#19265d; }
  .wrap     { max-width:540px; margin:40px auto; background:#fff; border-radius:14px; overflow:hidden; box-shadow:0 2px 18px rgba(0,0,0,.07); }
  .header   { background:#19265d; padding:32px 36px; text-align:center; }
  .logo     { font-size:1.35rem; font-weight:700; color:#F0EDE8; letter-spacing:-.01em; }
  .logo span{ color:#C8873A; }
  .body     { padding:36px; }
  h1        { font-size:1.25rem; font-weight:700; margin:0 0 8px; }
  p         { font-size:.9rem; line-height:1.7; color:#444; margin:0 0 16px; }
  .cred-box { background:#F7F5F2; border:1.5px solid rgba(0,0,0,.08); border-radius:10px; padding:20px 22px; margin:22px 0; }
  .cred-row { display:flex; justify-content:space-between; align-items:center; margin-bottom:10px; font-size:.87rem; }
  .cred-row:last-child { margin-bottom:0; }
  .cred-label { color:#6B6560; font-weight:600; text-transform:uppercase; font-size:.7rem; letter-spacing:.06em; }
  .cred-value { font-weight:700; color:#19265d; font-size:.92rem; font-family:monospace; }
  .btn      { display:block; width:fit-content; margin:24px auto 0; padding:13px 32px; background:#C8873A; color:#fff; text-decoration:none; border-radius:9px; font-weight:700; font-size:.88rem; text-align:center; }
  .footer   { padding:22px 36px; border-top:1px solid rgba(0,0,0,.07); text-align:center; font-size:.75rem; color:#9E9890; }
  .notice   { background:rgba(200,135,58,.07); border:1px solid rgba(200,135,58,.22); border-radius:9px; padding:12px 16px; font-size:.8rem; color:#7a4e12; line-height:1.6; margin-top:20px; }
</style>
</head>
<body>
  <div class="wrap">
    <div class="header">
      <div class="logo">Terra<span>.</span></div>
    </div>

    <div class="body">
      <h1>Welcome to Terra, {{ $name }}!</h1>
      <p>Your professional account has been created on the Terra platform. You can log in immediately using the credentials below.</p>

      <div class="cred-box">
        <div class="cred-row">
          <span class="cred-label">Email</span>
          <span class="cred-value">{{ $email }}</span>
        </div>
        <div class="cred-row">
          <span class="cred-label">Password</span>
          <span class="cred-value">{{ $plainPassword }}</span>
        </div>
      </div>

      <a href="{{ $loginUrl }}" class="btn">Log in to Terra →</a>

      <div class="notice">
        🔒 For your security, please change your password after your first login from your account settings.
      </div>

      <p style="margin-top:24px;font-size:.8rem;color:#9E9890">
        Your profile will appear in the Terra professional directory once an administrator has reviewed and verified your credentials.
      </p>
    </div>

    <div class="footer">
      © {{ date('Y') }} Terra Measures Ltd · Kigali, Rwanda<br>
      You received this email because an account was created for you on Terra.
    </div>
  </div>
</body>
</html>
