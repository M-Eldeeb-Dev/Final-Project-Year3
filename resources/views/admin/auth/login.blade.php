<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deebify Admin | Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0" rel="stylesheet">
</head>
<body class="bg-[#0A0A0A] text-gray-300 min-h-screen flex items-center justify-center font-sans antialiased">

    <div class="w-full max-w-md p-8 bg-[#111] rounded-lg border border-[#C9A84C] border-opacity-30 shadow-2xl">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-[#C9A84C] tracking-widest uppercase mb-2">Deebify</h1>
            <p class="text-sm text-gray-500 uppercase tracking-widest">Admin Login</p>
        </div>

        @if(session('error'))
            <div class="bg-red-900 border-l-4 border-red-500 text-red-200 p-4 mb-6 rounded text-sm">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-4 py-2 bg-[#0A0A0A] text-white border border-gray-700 rounded focus:outline-none focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] transition-colors">
                @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password" required
                           class="w-full px-4 py-2 bg-[#0A0A0A] text-white border border-gray-700 rounded focus:outline-none focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] transition-colors">
                    <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-[#C9A84C] transition-colors">
                        <span class="material-symbols-outlined" id="eyeIcon">visibility</span>
                    </button>
                </div>
                @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <button type="submit"
                    class="w-full py-3 bg-[#C9A84C] hover:bg-[#b09038] text-black font-bold uppercase tracking-wider rounded transition-colors mt-4">
                Sign In
            </button>
        </form>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye icon
            eyeIcon.textContent = type === 'password' ? 'visibility' : 'visibility_off';
        });
    </script>
</body>
</html>
