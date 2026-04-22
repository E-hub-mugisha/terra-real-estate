<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>New Appointment – Terra</title>
<style>
  body { font-family: Arial, sans-serif; background: #f3f4f6; margin: 0; padding: 20px; }
  .wrapper { max-width: 560px; margin: 0 auto; background: #fff; border-radius: 12px; overflow: hidden; }
  .header { background: #0F6E56; padding: 28px 32px; text-align: center; }
  .header img { height: 36px; }
  .header h1 { color: #fff; margin: 12px 0 0; font-size: 20px; font-weight: 600; }
  .body { padding: 28px 32px; }
  .body p { font-size: 15px; color: #374151; line-height: 1.6; margin: 0 0 14px; }
  .detail-box { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 10px; padding: 16px 20px; margin: 20px 0; }
  .detail-row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 14px; border-bottom: 1px solid #f3f4f6; }
  .detail-row:last-child { border-bottom: none; }
  .detail-label { color: #6b7280; }
  .detail-val { font-weight: 600; color: #1a1a1a; text-align: right; }
  .client-box { background: #f0fdf6; border: 1px solid #bbf0d9; border-radius: 10px; padding: 16px 20px; margin: 20px 0; }
  .client-box h3 { font-size: 15px; color: #0F6E56; margin: 0 0 10px; }
  .client-box a { color: #1D9E75; }
  .btn { display: inline-block; background: #1D9E75; color: #fff; text-decoration: none; padding: 12px 28px; border-radius: 8px; font-size: 14px; font-weight: 600; margin: 8px 0; }
  .footer { background: #f9fafb; padding: 20px 32px; text-align: center; font-size: 12px; color: #9ca3af; }
  .footer a { color: #1D9E75; text-decoration: none; }
</style>
</head>
<body>
<div class="wrapper">

  <div class="header">
    <img src="{{ config('app.url') }}/front/assets/img/logo/logo-wc.png" alt="Terra Real Estate">
    <h1>New Appointment Confirmed 📋</h1>
  </div>

  <div class="body">

    <p>Dear <strong>{{ $booking->consultant->name }}</strong>,</p>

    <p>
      You have a new confirmed appointment through Terra Real Estate. Please review the details below
      and reach out to the client to confirm the exact meeting time and location.
    </p>

    <div class="detail-box">
      <div class="detail-row">
        <span class="detail-label">Reference</span>
        <span class="detail-val">{{ $booking->reference }}</span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Service requested</span>
        <span class="detail-val">{{ $booking->service_label }}</span>
      </div>
      <div class="detail-row">
        <span class="detail-label">District</span>
        <span class="detail-val">{{ $booking->district }}, {{ $booking->province }}</span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Preferred date</span>
        <span class="detail-val">{{ $booking->appointment_date?->format('D, d M Y') ?? 'To be arranged' }}</span>
      </div>
      @if($booking->notes)
      <div class="detail-row">
        <span class="detail-label">Client notes</span>
        <span class="detail-val" style="max-width:300px;text-align:right;">{{ $booking->notes }}</span>
      </div>
      @endif
    </div>

    <div class="client-box">
      <h3>Client contact details</h3>
      <p><strong>{{ $booking->client_name }}</strong></p>
      <p style="margin-top:6px;font-size:14px;">
        📞 <a href="tel:{{ $booking->client_phone }}">{{ $booking->client_phone }}</a><br>
        ✉️ <a href="mailto:{{ $booking->client_email }}">{{ $booking->client_email }}</a>
      </p>
    </div>

    <p>
      Please contact the client as soon as possible to confirm the appointment details.
      If you are unable to fulfill this appointment, contact Terra at
      <a href="mailto:terraltd.rd@gmail.com" style="color:#1D9E75;">terraltd.rd@gmail.com</a>.
    </p>

    <p style="text-align:center;margin-top:24px;">
      <a href="{{ url('/') }}" class="btn">Visit Terra Dashboard</a>
    </p>

  </div>

  <div class="footer">
    <p>
      <a href="{{ url('/') }}">terra.rw</a> &nbsp;·&nbsp;
      Kigali, Rwanda &nbsp;·&nbsp;
      <a href="tel:+250796511725">+250 796 511 725</a>
    </p>
    <p style="margin-top:6px;">© {{ date('Y') }} Terra Real Estate. All rights reserved.</p>
  </div>

</div>
</body>
</html>
