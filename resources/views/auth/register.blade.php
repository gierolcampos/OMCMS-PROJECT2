<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICS Organization Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="min-h-screen flex items-center justify-center" style="background: url('{{ asset('img/bg.png') }}') no-repeat center center; background-size: cover;">

    <!-- Glassmorphism Card -->
    <div class="relative w-full max-w-md p-8 rounded-2xl shadow-2xl bg-white border border-white/40">
        <!-- Logo overlapping -->
        <div class="absolute left-1/2 -top-16 transform -translate-x-1/2">
            <img src="{{ asset('img/ics-logo.png') }}" alt="Logo" class="w-28 h-28 rounded-full bg-white shadow-xl border-4 border-white object-contain">
        </div>

        <div class="mt-16">
            <h2 class="text-center text-3xl font-extrabold text-gray-900 tracking-tight drop-shadow">
                ICS ORGANIZATION
            </h2>
            <p class="mt-2 text-center text-base text-gray-700 font-medium">
                Navotas Polytechnic College - Integrated Computer Society
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-6 mt-8">
            @csrf

            <!-- Student Number -->
            <div>
                <label for="studentnumber" class="block text-sm font-semibold text-gray-700">Student Number</label>
                <input id="studentnumber" name="studentnumber" type="text" required autofocus autocomplete="studentnumber" oninput="generateEmail()" maxlength="6" pattern="[0-9]{6}" placeholder="Student Number"
                    class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition px-4 py-2 bg-white placeholder-gray-400"
                    value="{{ old('studentnumber') }}">
            </div>
            <!-- First Name -->
            <div>
                <label for="firstname" class="block text-sm font-semibold text-gray-700">First Name</label>
                <input id="firstname" name="firstname" type="text" required autofocus autocomplete="firstname" oninput="generateEmail()"
                    class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition px-4 py-2 bg-white placeholder-gray-400"
                    value="{{ old('firstname') }}">
            </div>

            <div>
                <label for="middlename" class="block text-sm font-semibold text-gray-700">First Name</label>
                <input id="middlename" name="middlename" type="text" required autofocus autocomplete="middlename" oninput="generateEmail()"
                    class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition px-4 py-2 bg-white placeholder-gray-400"
                    value="{{ old('middlename') }}">
            </div>

            <!-- Last Name -->
            <div>
                <label for="lastname" class="block text-sm font-semibold text-gray-700">Last Name</label>
                <input id="lastname" name="lastname" type="text" required autofocus autocomplete="lastname" oninput="generateEmail()"
                    class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition px-4 py-2 bg-white placeholder-gray-400"
                    value="{{ old('lastname') }}">
            </div>

            <div>
                <label for="suffix" class="block text-sm font-semibold text-gray-700">Last Name</label>
                <input id="suffix" name="suffix" type="text" required autofocus autocomplete="suffix" oninput="generateEmail()"
                    class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition px-4 py-2 bg-white placeholder-gray-400"
                    value="{{ old('lastname') }}">
            </div>
            
            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700">NPC Email</label>
                <input id="email" name="email" type="email" required autocomplete="username" 
                    class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition px-4 py-2 bg-white placeholder-gray-400"
                    value="{{ old('email') }}">
            </div>
            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                <input id="password" name="password" type="password" required autocomplete="new-password"
                    class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition px-4 py-2 bg-white placeholder-gray-400">
            </div>
            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                    class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition px-4 py-2 bg-white placeholder-gray-400">
            </div>
            <div class="flex items-center justify-end mt-4 space-x-5">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" href="{{ route('login') }}">
                    Already registered?
                </a>
                <button type="submit" class="py-2 px-4 bg-red-600 hover:bg-red-700 text-sm font-semibold rounded-lg text-white transition shadow">
                    Register
                </button>
            </div>
        </form>
        <script>
            function generateEmail() {
                const firstname = document.getElementById('firstname').value.trim();
                const lastname = document.getElementById('lastname').value.trim().toLowerCase();
                const studentnumber = document.getElementById('studentnumber').value.trim();
                if (firstname && lastname && studentnumber) {
                    const firstLetters = firstname.split(' ')
                        .filter(word => word.length > 0)
                        .map(word => word[0].toLowerCase())
                        .join('');
                    const email = firstLetters + lastname + studentnumber + '@navotaspolytechniccollege.edu.ph';
                    document.getElementById('email').value = email;
                }
            }
            window.onload = generateEmail;
        </script>
    </div>
</body>
</html>
