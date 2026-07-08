<!DOCTYPE html>
<html>
<head>
    <title>Reset Password OTP</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <h2 style="color: #333333; text-align: center;">Reset Password - Sialan App</h2>
        <p style="color: #555555; font-size: 16px;">Halo <strong>{{ $petugasName }}</strong>,</p>
        <p style="color: #555555; font-size: 16px;">Kami menerima permintaan untuk melakukan reset password pada akun Anda. Berikut adalah kode OTP 6-digit Anda:</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <span style="display: inline-block; padding: 15px 30px; font-size: 32px; font-weight: bold; color: #1E3A8A; background-color: #DBEAFE; border-radius: 8px; letter-spacing: 5px;">
                {{ $otpCode }}
            </span>
        </div>

        <p style="color: #555555; font-size: 14px;">Kode OTP ini hanya berlaku selama <strong>15 menit</strong>. Jangan bagikan kode ini kepada siapapun.</p>
        <p style="color: #555555; font-size: 14px;">Jika Anda tidak merasa meminta reset password, silakan abaikan email ini.</p>
        
        <hr style="border: none; border-top: 1px solid #eeeeee; margin: 30px 0;">
        <p style="color: #999999; font-size: 12px; text-align: center;">&copy; {{ date('Y') }} Sialan App. All rights reserved.</p>
    </div>
</body>
</html>
