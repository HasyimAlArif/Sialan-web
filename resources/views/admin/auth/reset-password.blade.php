<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Password Baru | SiALAN Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #4f46e5; --primary-hover: #4338ca; --bg-color: #0f172a; --surface: rgba(30,41,59,0.7); --text-main: #f8fafc; --text-muted: #94a3b8; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body {
            background-color: var(--bg-color);
            background-image: radial-gradient(at 0% 0%, rgba(79,70,229,0.3) 0px, transparent 50%), radial-gradient(at 100% 100%, rgba(16,185,129,0.2) 0px, transparent 50%);
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            color: var(--text-main); padding: 20px; position: relative; overflow: hidden;
        }
        .orb { position: absolute; border-radius: 50%; filter: blur(80px); z-index: 0; animation: float 10s ease-in-out infinite alternate; }
        .orb-1 { width: 300px; height: 300px; background: rgba(79,70,229,0.4); top: 10%; left: 20%; }
        .orb-2 { width: 380px; height: 380px; background: rgba(16,185,129,0.25); bottom: -10%; right: 10%; animation-delay: -5s; }
        @keyframes float { 0% { transform: translateY(0) scale(1); } 100% { transform: translateY(-30px) scale(1.1); } }
        .card {
            background: var(--surface); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.1); padding: 3rem; border-radius: 24px;
            width: 100%; max-width: 440px; z-index: 1;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
            animation: slideUp 0.6s cubic-bezier(0.16,1,0.3,1);
        }
        @keyframes slideUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
        .icon-wrap { width: 64px; height: 64px; background: linear-gradient(135deg, rgba(79,70,229,0.3), rgba(192,132,252,0.3)); border: 1px solid rgba(129,140,248,0.3); border-radius: 18px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; }
        .logo-area { text-align: center; margin-bottom: 2.5rem; }
        .logo-area h1 { font-size: 1.6rem; font-weight: 700; margin-bottom: 0.4rem; background: linear-gradient(to right, #818cf8, #c084fc); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .logo-area p { color: var(--text-muted); font-size: 0.9rem; line-height: 1.6; }
        .form-group { margin-bottom: 1.4rem; }
        .form-group label { display: block; font-size: 0.8rem; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; }
        .form-control { width: 100%; background: rgba(15,23,42,0.6); border: 1px solid rgba(255,255,255,0.1); color: white; padding: 0.85rem 1.2rem; border-radius: 12px; font-size: 1rem; transition: all 0.3s; outline: none; }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(79,70,229,0.2); }
        .form-control::placeholder { color: #475569; }
        .hint { font-size: 0.78rem; color: var(--text-muted); margin-top: 0.4rem; }
        .strength-bar { height: 4px; border-radius: 2px; background: rgba(255,255,255,0.1); margin-top: 8px; overflow: hidden; }
        .strength-fill { height: 100%; width: 0%; transition: width 0.4s, background 0.4s; border-radius: 2px; }
        .btn-submit { width: 100%; background: var(--primary); color: white; border: none; padding: 1rem; font-size: 1rem; font-weight: 600; border-radius: 12px; cursor: pointer; transition: all 0.3s; margin-top: 0.5rem; box-shadow: 0 4px 14px rgba(79,70,229,0.39); }
        .btn-submit:hover { background: var(--primary-hover); transform: translateY(-2px); box-shadow: 0 6px 20px rgba(79,70,229,0.5); }
        .alert { padding: 0.9rem 1rem; border-radius: 12px; margin-bottom: 1.5rem; font-size: 0.9rem; display: flex; align-items: flex-start; gap: 10px; }
        .alert-error { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2); color: #fca5a5; }
        .divider { border: none; border-top: 1px solid rgba(255,255,255,0.07); margin: 1.8rem 0 1.5rem; }
        .back-link { display: flex; align-items: center; justify-content: center; gap: 6px; color: var(--text-muted); text-decoration: none; font-size: 0.9rem; transition: color 0.3s; }
        .back-link:hover { color: white; }
    </style>
</head>
<body>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="card">

        <div class="logo-area">
            <div class="icon-wrap">
                <svg width="28" height="28" fill="none" stroke="#818cf8" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                </svg>
            </div>
            <h1>Password Baru</h1>
            <p>Buat password baru yang kuat untuk akun admin Anda.</p>
        </div>

        @if($errors->any())
            <div class="alert alert-error">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:2px"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.password.update') }}">
            @csrf
            {{-- Token & email tersembunyi dari URL --}}
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="form-group">
                <label for="password">Password Baru</label>
                <input type="password" id="password" name="password" class="form-control"
                    placeholder="Minimal 8 karakter" required oninput="cekKekuatan(this.value)">
                <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
                <p class="hint" id="strengthText"></p>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="form-control" placeholder="Ulangi password baru" required>
            </div>

            <button type="submit" class="btn-submit">Simpan Password Baru</button>
        </form>

        <hr class="divider">
        <a href="{{ route('admin.login') }}" class="back-link">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke login
        </a>
    </div>

    <script>
        function cekKekuatan(pw) {
            const fill = document.getElementById('strengthFill');
            const text = document.getElementById('strengthText');
            let score = 0;
            if (pw.length >= 8)  score++;
            if (/[A-Z]/.test(pw)) score++;
            if (/[0-9]/.test(pw)) score++;
            if (/[^A-Za-z0-9]/.test(pw)) score++;

            const levels = [
                { pct: '0%',   color: 'transparent',  label: '' },
                { pct: '25%',  color: '#ef4444',       label: 'Lemah' },
                { pct: '50%',  color: '#f97316',       label: 'Cukup' },
                { pct: '75%',  color: '#eab308',       label: 'Baik' },
                { pct: '100%', color: '#22c55e',       label: 'Kuat' },
            ];
            const lvl = pw.length === 0 ? 0 : score;
            fill.style.width      = levels[lvl].pct;
            fill.style.background = levels[lvl].color;
            text.textContent      = levels[lvl].label;
            text.style.color      = levels[lvl].color;
        }
    </script>
</body>
</html>
