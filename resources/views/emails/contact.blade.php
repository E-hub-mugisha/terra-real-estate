<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .wrapper {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .header {
            background: #1a1a2e;
            padding: 30px 40px;
            text-align: center;
        }

        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 22px;
            letter-spacing: 1px;
        }

        .body {
            padding: 35px 40px;
            color: #333333;
        }

        .body h2 {
            font-size: 18px;
            margin-top: 0;
            color: #1a1a2e;
        }

        .field {
            margin-bottom: 20px;
        }

        .label {
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            color: #888888;
            margin-bottom: 4px;
        }

        .value {
            font-size: 15px;
            color: #222222;
        }

        .message {
            background: #f9f9f9;
            border-left: 4px solid #1a1a2e;
            padding: 15px 20px;
            border-radius: 4px;
            font-size: 15px;
            line-height: 1.7;
            color: #444;
        }

        .footer {
            background: #f0f0f0;
            text-align: center;
            padding: 20px 40px;
            font-size: 12px;
            color: #999999;
        }

        .divider {
            border: none;
            border-top: 1px solid #eeeeee;
            margin: 25px 0;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="header">
            <h1>{{ config('app.name') }} — New Contact Message</h1>
        </div>
        <div class="body">
            <h2>You have received a new enquiry</h2>
            <hr class="divider">
            <div class="field">
                <div class="label">Full Name</div>
                <div class="value">{{ $first_name }} {{ $last_name }}</div>
            </div>
            <div class="field">
                <div class="label">Email Address</div>
                <div class="value"><a href="mailto:{{ $email }}">{{ $email }}</a></div>
            </div>
            @if($phone)
            <div class="field">
                <div class="label">Phone Number</div>
                <div class="value">{{ $phone }}</div>
            </div>
            @endif
            <div class="field">
                <div class="label">Subject</div>
                <div class="value">{{ $subject ?? 'No subject provided' }}</div>
            </div>
            <hr class="divider">
            <div class="field">
                <div class="label">Message</div>
                <div class="message">{{ $body }}</div>
            </div>
        </div>
        <div class="footer">
            This message was sent via the contact form on {{ config('app.url') }}<br>
            {{ now()->format('l, d F Y \a\t H:i') }}
        </div>
    </div>
</body>

</html>