<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | SiALAN</title>
    <!-- Menggunakan font premium Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #d1d5db; /* Sedikit digelapkan agar kontras font putih box biru lebih menonjol */
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Plus Jakarta Sans', sans-serif; /* Font baru */
        }

        .split-layout {
            display: flex;
            width: 100%;
            max-width: 1050px;
            margin: 0 auto;
            align-items: center;
            justify-content: space-between;
            padding: 2rem;
            gap: 5rem;
        }

        /* LEFT SIDE */
        .left-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .left-content h1 {
            font-size: 2.5rem;
            font-weight: 800;
            color: #0f4296; /* Dark blue */
            margin-bottom: 0.2rem;
            letter-spacing: -0.5px;
        }

        .left-content h2 {
            font-size: 3.5rem;
            font-weight: 600;
            color: #1a56bc; /* Blue */
            line-height: 1.15;
            letter-spacing: -1px;
            min-height: 180px; /* Menjaga tinggi agar box kanan tidak goyang saat mengetik */
        }

        /* Cursor untuk efek mengetik */
        .typing-cursor {
            display: inline-block;
            width: 4px;
            background-color: #1a56bc;
            animation: blink 1s step-end infinite;
            margin-left: 4px;
            vertical-align: text-bottom;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }

        /* RIGHT SIDE */
        .right-content {
            flex: 1;
            display: flex;
            justify-content: flex-end;
        }

        .login-box {
            background-color: #0b45a3; /* Solid premium blue box */
            padding: 3.5rem;
            border-radius: 24px;
            width: 100%;
            max-width: 460px;
            color: white;
            box-shadow: 0 20px 40px rgba(11, 69, 163, 0.2);
        }

        .login-box h3 {
            text-align: center;
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 3rem;
            letter-spacing: 1.5px;
        }

        .form-group {
            margin-bottom: 1.8rem;
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }

        .form-group label {
            font-size: 0.9rem;
            font-weight: 500;
            margin-left: 1.2rem;
            letter-spacing: 0.5px;
        }

        .form-control {
            width: 100%;
            background: transparent;
            border: 2px solid rgba(255, 255, 255, 0.9);
            color: white;
            padding: 1.1rem 1.5rem;
            border-radius: 50px; /* Sangat bulat (pill) */
            font-size: 1.05rem;
            font-family: inherit;
            outline: none;
            transition: all 0.3s ease;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: white;
        }

        /* Lupa Password Link */
        .forgot-link-container {
            display: flex;
            justify-content: flex-end;
            margin-top: -0.5rem;
            margin-right: 1.2rem;
        }

        .forgot-link {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .forgot-link:hover {
            color: white;
            text-decoration: underline;
        }

        .btn-visible {
            width: 100%;
            background: white;
            color: #0b45a3;
            border: none;
            padding: 1.1rem;
            border-radius: 50px;
            font-size: 1.05rem;
            font-weight: 700;
            cursor: pointer;
            margin-top: 2.5rem;
            font-family: inherit;
            transition: transform 0.2s, background 0.3s, box-shadow 0.3s;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .btn-visible:hover {
            background: #f8fafc;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        /* Alerts */
        .alert {
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            text-align: center;
        }
        
        /* Mobile Responsiveness */
        @media (max-width: 900px) {
            .split-layout {
                flex-direction: column;
                padding: 1.5rem;
                gap: 2.5rem;
            }
            .left-content {
                text-align: center;
            }
            .left-content h1 {
                font-size: 2rem;
            }
            .left-content h2 {
                font-size: 2.5rem;
                min-height: 120px;
            }
            .right-content {
                justify-content: center;
                width: 100%;
            }
            .login-box {
                padding: 2.5rem 1.5rem;
            }
        }
    </style>
</head>
<body>

    <div class="split-layout">
        <!-- Bagian Kiri -->
        <div class="left-content">
            <h1>SIAlan</h1>
            <h2 id="typing-container">
                <!-- Teks akan diketik oleh JavaScript -->
            </h2>
        </div>

        <!-- Bagian Kanan (Box Biru) -->
        <div class="right-content">
            <div class="login-box">
                <h3>PORTAL ADMIN</h3>

                @if(session('error'))
                    <div class="alert">
                        {{ session('error') }}
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">username</label>
                        <input type="email" id="email" name="email" class="form-control" required autocomplete="email" autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password">password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>

                    <div class="forgot-link-container">
                        <a href="{{ route('admin.password.request') }}" class="forgot-link">Lupa Password</a>
                    </div>

                    <button type="submit" class="btn-visible">LOGIN</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Script Animasi Mengetik Berulang (Looping) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const textToType = "Sistem\nInformasi\nKelayakan\nJalan";
            const container = document.getElementById('typing-container');
            
            let i = 0;
            let isDeleting = false;
            
            const typingSpeed = 80;    // Kecepatan ngetik
            const deletingSpeed = 40;  // Kecepatan menghapus
            const pauseEnd = 3000;     // Jeda saat teks selesai diketik (3 detik)
            const pauseStart = 800;    // Jeda sebelum mulai ngetik lagi
            
            function typeWriter() {
                // Ubah format \n menjadi <br> khusus untuk teks yang sudah terketik
                let currentText = textToType.substring(0, i).replace(/\n/g, '<br>');
                
                // Render teks + kursor berkedip
                container.innerHTML = currentText + '<span class="typing-cursor">&nbsp;</span>';

                if (!isDeleting && i < textToType.length) {
                    // Proses mengetik maju
                    i++;
                    setTimeout(typeWriter, typingSpeed);
                } 
                else if (isDeleting && i > 0) {
                    // Proses menghapus (backspace)
                    i--;
                    setTimeout(typeWriter, deletingSpeed);
                } 
                else if (!isDeleting && i === textToType.length) {
                    // Teks lengkap, tunggu beberapa detik lalu mulai menghapus
                    isDeleting = true;
                    setTimeout(typeWriter, pauseEnd);
                } 
                else if (isDeleting && i === 0) {
                    // Teks habis terhapus, tunggu sebentar lalu mulai mengetik lagi
                    isDeleting = false;
                    setTimeout(typeWriter, pauseStart);
                }
            }
            
            // Mulai animasi
            setTimeout(typeWriter, pauseStart);
        });
    </script>
</body>
</html>
