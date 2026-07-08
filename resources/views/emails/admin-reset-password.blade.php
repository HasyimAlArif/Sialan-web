<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - SiALAN</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background-color: #f1f5f9;
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #334155;
            padding: 40px 20px;
        }

        .wrapper {
            max-width: 580px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 24px;
        }

        .header h1 {
            font-size: 1.6rem;
            font-weight: 700;
            background: linear-gradient(to right, #4f46e5, #7c3aed);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .card {
            background: #ffffff;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.07);
        }

        .icon-wrap {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #eef2ff, #f3e8ff);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }

        .greeting {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 12px;
            color: #1e293b;
        }

        .body-text {
            font-size: 0.95rem;
            line-height: 1.7;
            color: #64748b;
            margin-bottom: 32px;
        }

        .btn-wrap {
            text-align: center;
            margin-bottom: 32px;
        }

        .btn-reset {
            display: inline-block;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #ffffff !important;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 600;
            padding: 14px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
        }

        .divider {
            border: none;
            border-top: 1px solid #e2e8f0;
            margin: 28px 0;
        }

        .url-info {
            font-size: 0.82rem;
            color: #94a3b8;
            line-height: 1.6;
        }

        .url-info a {
            color: #6366f1;
            word-break: break-all;
        }

        .expire-note {
            background: #fff7ed;
            border: 1px solid #fed7aa;
            border-radius: 10px;
            padding: 14px 16px;
            font-size: 0.85rem;
            color: #92400e;
            margin-top: 24px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .footer {
            text-align: center;
            margin-top: 28px;
            font-size: 0.82rem;
            color: #94a3b8;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="wrapper">

        <!-- Header -->
        <div class="header">
            <h1>SiALAN</h1>
        </div>

        <!-- Card -->
        <div class="card">

            <div class="icon-wrap">
                <svg width="30" height="30" fill="none" stroke="#4f46e5" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z"/>
                </svg>
            </div>

            <p class="greeting">Halo, {{ $adminName }}!</p>
            <p class="body-text">
                Kami menerima permintaan untuk mereset password akun Admin SiALAN Anda.
                Klik tombol di bawah ini untuk membuat password baru. Link ini hanya berlaku selama <strong>60 menit</strong>.
            </p>

            <div class="btn-wrap">
                <a href="{{ $resetUrl }}" class="btn-reset">
                    Reset Password Sekarang
                </a>
            </div>

            <div class="expire-note">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Jika Anda tidak meminta reset password, abaikan email ini. Akun Anda tetap aman.</span>
            </div>

            <hr class="divider">

            <p class="url-info">
                Jika tombol di atas tidak berfungsi, salin dan tempel URL berikut ke browser Anda:<br>
                <a href="{{ $resetUrl }}">{{ $resetUrl }}</a>
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            &copy; {{ date('Y') }} SiALAN &mdash; Sistem Aduan Jalanan<br>
            Email ini dikirim secara otomatis, harap jangan balas email ini.
        </div>

    </div>
</body>
</html>
