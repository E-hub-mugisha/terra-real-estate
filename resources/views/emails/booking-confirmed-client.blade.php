<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Consultation is Confirmed – Terra</title>
<style>
  body { font-family: Arial, sans-serif; background: #f3f4f6; margin: 0; padding: 20px; }
  .wrapper { max-width: 560px; margin: 0 auto; background: #fff; border-radius: 12px; overflow: hidden; }
  .header { background: #D05208; padding: 28px 32px; text-align: center; }
  .header img { height: 36px; }
  .header h1 { color: #fff; margin: 12px 0 0; font-size: 20px; font-weight: 600; }
  .body { padding: 28px 32px; }
  .body p { font-size: 15px; color: #374151; line-height: 1.6; margin: 0 0 14px; }
  .detail-box { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 10px; padding: 16px 20px; margin: 20px 0; }
  .detail-row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 14px; border-bottom: 1px solid #f3f4f6; }
  .detail-row:last-child { border-bottom: none; }
  .detail-label { color: #6b7280; }
  .detail-val { font-weight: 600; color: #1a1a1a; text-align: right; }
  .consultant-box { background: #f0fdf6; border: 1px solid #bbf0d9; border-radius: 10px; padding: 16px 20px; margin: 20px 0; }
  .consultant-box h3 { font-size: 15px; color: #0F6E56; margin: 0 0 10px; }
  .consultant-box p { margin: 0; font-size: 14px; color: #374151; }
  .consultant-box a { color: #D05208; }
  .note { font-size: 13px; color: #9ca3af; background: #f9fafb; padding: 12px 16px; border-radius: 8px; }
  .footer { background: #f9fafb; padding: 20px 32px; text-align: center; font-size: 12px; color: #9ca3af; }
  .footer a { color: #D05208; text-decoration: none; }
  .btn { display: inline-block; background: #D05208; color: #fff; text-decoration: none; padding: 12px 28px; border-radius: 8px; font-size: 14px; font-weight: 600; margin: 8px 0; }
</style>
</head>
<body>
<div class="wrapper">

  <div class="header">
    <img src="{{ config('app.url') }}/front/assets/img/logo/logo-wc.png" alt="Terra Real Estate">
    <h1>Your Consultation is Confirmed ✓</h1>
  </div>

  <div class="body">

    <p>Dear <strong>{{ $booking->client_name }}</strong>,</p>

    <p>
      Great news! Your consultation booking has been confirmed by the Terra team.
      Below are your appointment details and the consultant's contact information.
    </p>

    <div class="detail-box">
      <div class="detail-row">
        <span class="detail-label">Reference</span>
        <span class="detail-val">{{ $booking->reference }}</span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Service</span>
        <span class="detail-val">{{ $booking->service_label }}</span>
      </div>
      <div class="detail-row">
        <span class="detail-label">District</span>
        <span class="detail-val">{{ $booking->district }}, {{ $booking->province }}</span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Appointment date</span>
        <span class="detail-val">{{ $booking->appointment_date?->format('D, d M Y') ?? 'To be arranged' }}</span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Fee paid</span>
        <span class="detail-val">{{ number_format($booking->fee) }} RWF</span>
      </div>
    </div>

    <div class="consultant-box">
      <h3>Your consultant's contact details</h3>
      <p><strong>{{ $booking->consultant->name }}</strong></p>
      <p style="margin-top:6px;">
        📞 <a href="tel:{{ $booking->consultant->phone }}">{{ $booking->consultant->phone }}</a><br>
        ✉️ <a href="mailto:{{ $booking->consultant->email }}">{{ $booking->consultant->email }}</a>
      </p>
      <p style="margin-top:8px;font-size:13px;color:#6b7280;">
        Please reach out to confirm the exact time and venue for your appointment.
      </p>
    </div>

    <p>If you have any issues, reply to this email or contact Terra directly.</p>

    <p style="text-align:center;margin-top:24px;">
      <a href="{{ url('/') }}" class="btn">Visit Terra</a>
    </p>

    <div class="note">
      ⚠️ If you did not make this booking, please contact us immediately at
      <a href="mailto:terraltd.rd@gmail.com">terraltd.rd@gmail.com</a>.
    </div>

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
