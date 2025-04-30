<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICS Organization Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="min-h-screen flex items-center justify-center" style="background: url('{{ asset('img/bg.png') }}') no-repeat center center; background-size: cover;">

    <!-- Glassmorphism Card -->
    <div class="relative w-full max-w-md p-8 rounded-2xl shadow-2xl bg-white border border-white/40">
        
        <!-- Logo overlapping -->
        <div class="absolute left-1/2 -top-16 transform -translate-x-1/2">
            <img src="{{ asset('img/ics-logo.png') }}" alt="Logo" class="w-28 h-28 rounded-full bg-white shadow-xl border-4 border-white object-contain">
        </div>

        <div class="mt-12">
            <h2 class="text-center text-3xl font-extrabold text-gray-900 tracking-tight drop-shadow">
                ICS ORGANIZATION
            </h2>
            <p class="mt-2 text-center text-base text-gray-700 font-medium">
                Navotas Polytechnic College - Integrated Computer Society
            </p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6 mt-8">
            @csrf
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
                <input id="email" name="email" type="email" required
                    class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition px-4 py-2 bg-white/80 backdrop-blur placeholder-gray-400"
                    value="{{ old('email') }}">
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                <input id="password" name="password" type="password" required
                    class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition px-4 py-2 bg-white/80 backdrop-blur placeholder-gray-400">
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input id="remember" name="remember" type="checkbox"
                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded transition">
                <label for="remember" class="ml-2 block text-sm text-gray-900">
                    Remember me
                </label>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-2 mt-4">
                <a href="{{ route('register') }}">
                    <button type="button"
                        class="py-2 px-4 bg-red-600 hover:bg-red-700 text-sm font-semibold rounded-lg text-white transition shadow">
                        Register
                    </button>
                </a>
                <button type="submit"
                    class="py-2 px-4 bg-red-600 hover:bg-red-700 text-sm font-semibold rounded-lg text-white transition shadow">
                    Log in
                </button>
            </div>
        </form>
    </div>

</body>
</html>
