<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password | SiALAN Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --bg-color: #0f172a;
            --surface: rgba(30, 41, 59, 0.7);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body {
            background-color: var(--bg-color);
            background-image:
                radial-gradient(at 0% 100%, rgba(79, 70, 229, 0.3) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(236, 72, 153, 0.25) 0px, transparent 50%);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            color: var(--text-main); padding: 20px; position: relative; overflow: hidden;
        }
        .orb { position: absolute; border-radius: 50%; filter: blur(80px); z-index: 0; animation: float 10s ease-in-out infinite alternate; }
        .orb-1 { width: 280px; height: 280px; background: rgba(79, 70, 229, 0.4); bottom: 10%; left: 15%; }
        .orb-2 { width: 350px; height: 350px; background: rgba(236, 72, 153, 0.3); top: -5%; right: 10%; animation-delay: -5s; }
        @keyframes float { 0% { transform: translateY(0) scale(1); } 100% { transform: translateY(-30px) scale(1.1); } }
        .card {
            background: var(--surface); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.1); padding: 3rem; border-radius: 24px;
            width: 100%; max-width: 420px; z-index: 1;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes slideUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
        .icon-wrap {
            width: 64px; height: 64px;
            background: linear-gradient(135deg, rgba(79,70,229,0.3), rgba(192,132,252,0.3));
            border: 1px solid rgba(129,140,248,0.3);
            border-radius: 18px; display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.5rem;
        }
        .logo-area { text-align: center; margin-bottom: 2rem; }
        .logo-area h1 {
            font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;
            background: linear-gradient(to right, #818cf8, #c084fc);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .logo-area p { color: var(--text-muted); font-size: 0.9rem; line-height: 1.6; }
        .form-group { margin-bottom: 1.4rem; }
        .form-group label { display: block; font-size: 0.8rem; font-weight: 500; margin-bottom: 0.5rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; }
        .form-control { width: 100%; background: rgba(15,23,42,0.6); border: 1px solid rgba(255,255,255,0.1); color: white; padding: 0.85rem 1.2rem; border-radius: 12px; font-size: 1rem; transition: all 0.3s; outline: none; }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(79,70,229,0.2); }
        .form-control::placeholder { color: #475569; }
        .btn-submit { width: 100%; background: var(--primary); color: white; border: none; padding: 1rem; font-size: 1rem; font-weight: 600; border-radius: 12px; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 14px rgba(79,70,229,0.39); }
        .btn-submit:hover { background: var(--primary-hover); transform: translateY(-2px); box-shadow: 0 6px 20px rgba(79,70,229,0.5); }
        .alert { padding: 0.9rem 1rem; border-radius: 12px; margin-bottom: 1.5rem; font-size: 0.9rem; display: flex; align-items: flex-start; gap: 10px; }
        .alert-error { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2); color: #fca5a5; }
        .alert-success { background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.2); color: #6ee7b7; }
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
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                </svg>
            </div>
            <h1>Lupa Password?</h1>
            <p>Masukkan email akun admin Anda. Kami akan mengirimkan link reset password ke inbox Anda.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:2px"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:2px"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.password.send') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email Admin</label>
                <input type="email" id="email" name="email" class="form-control"
                    placeholder="admin@example.com" value="{{ old('email') }}" required autofocus>
            </div>
            <button type="submit" class="btn-submit">Kirim Link Reset</button>
        </form>

        <hr class="divider">
        <a href="{{ route('admin.login') }}" class="back-link">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke login
        </a>
    </div>
</body>
</html>
