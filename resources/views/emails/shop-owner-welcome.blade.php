<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Welcome to Terra</title>
</head>
<body style="margin:0; padding:0; background-color:#f3f4f8; font-family: 'DM Sans', Arial, sans-serif;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f3f4f8; padding: 32px 16px;">
    <tr>
        <td align="center">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:560px; background:#ffffff; border-radius:14px; overflow:hidden; border:1px solid #eef0f5;">

                {{-- Header --}}
                <tr>
                    <td style="background-color:#19265d; padding:28px 32px;">
                        <span style="color:#ffffff; font-size:20px; font-weight:700;">Terra</span>
                    </td>
                </tr>

                {{-- Body --}}
                <tr>
                    <td style="padding:32px;">
                        <h1 style="margin:0 0 12px; color:#111a45; font-size:22px;">Welcome, {{ $user->name }}!</h1>
                        <p style="margin:0 0 20px; color:#4b5563; font-size:15px; line-height:1.6;">
                            An account has been created for you on Terra as the owner of
                            <strong style="color:#111a45;">{{ $shop->name }}</strong>. You can use it to
                            manage your shop and the products you list.
                        </p>

                        {{-- Credentials box --}}
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                            style="background-color:#fff3e9; border-radius:10px; margin-bottom:24px;">
                            <tr>
                                <td style="padding:18px 20px;">
                                    <p style="margin:0 0 10px; color:#D05208; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:.04em;">
                                        Your login details
                                    </p>
                                    <p style="margin:0 0 6px; color:#111a45; font-size:14px;">
                                        <strong>Email:</strong> {{ $user->email }}
                                    </p>
                                    <p style="margin:0; color:#111a45; font-size:14px;">
                                        <strong>Password:</strong> {{ $plainPassword }}
                                    </p>
                                </td>
                            </tr>
                        </table>

                        <p style="margin:0 0 24px; color:#6b7280; font-size:13px; line-height:1.6;">
                            For your security, please sign in and change this password as soon as possible.
                        </p>

                        {{-- CTA --}}
                        <table role="presentation" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="border-radius:8px; background-color:#D05208;">
                                    <a href="{{ $loginUrl }}"
                                        style="display:inline-block; padding:12px 28px; color:#ffffff; font-size:14px; font-weight:600; text-decoration:none;">
                                        Sign In to Terra
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                {{-- Footer --}}
                <tr>
                    <td style="padding:20px 32px; border-top:1px solid #eef0f5;">
                        <p style="margin:0; color:#9ca3af; font-size:12px;">
                            If you weren't expecting this account, you can safely ignore this email.
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</body>
</html>
