<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white p-8 rounded shadow w-96">
    <h1 class="text-xl font-bold mb-4 text-center">Login Admin</h1>

    @if(session('error'))
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 p-3 rounded mb-3 text-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded mb-3 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-2 rounded mb-3">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login') }}" class="space-y-3">
        @csrf

        <input type="email" name="email" placeholder="Email"
            class="w-full border p-2 rounded" required>

        <input type="password" name="password" placeholder="Password"
            class="w-full border p-2 rounded" required>

        <button class="w-full bg-blue-600 text-white p-2 rounded">
            Login
        </button>
    </form>
</div>

</body>
</html>
