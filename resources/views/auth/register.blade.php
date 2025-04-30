<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICS Organization Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
        .logo-container {
            position: relative;
            z-index: 10;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center py-24" style="background: url('{{ asset('img/bg.png') }}') no-repeat center center; background-size: cover;">

    <!-- Glassmorphism Card -->
    <div class="relative w-full max-w-4xl mx-4 bg-white rounded-2xl shadow-2xl border border-white/40">
        <!-- Logo Container -->
        <div class="logo-container flex justify-center -mt-20">
            <img src="{{ asset('img/ics-logo.png') }}" alt="Logo" class="w-36 h-36 rounded-full bg-white shadow-xl border-4 border-white object-contain">
        </div>

        <div class="p-8">
            <div class="mb-8">
                <h2 class="text-center text-3xl font-extrabold text-gray-900 tracking-tight drop-shadow">
                    ICS ORGANIZATION
                </h2>
                <p class="mt-2 text-center text-base text-gray-700 font-medium">
                    Navotas Polytechnic College - Integrated Computer Society
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="mt-8">
                @csrf
                <!-- Full Width Student Number -->
                <div class="mb-6">
                    <label for="studentnumber" class="block text-sm font-semibold text-gray-700">Student Number</label>
                    <input id="studentnumber" name="studentnumber" type="text" required autofocus autocomplete="studentnumber" 
                        oninput="generateEmail()" maxlength="6" pattern="[0-9]{6}" placeholder="Student Number"
                        class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-red-400 focus:border-red-500 transition px-4 py-2 bg-white placeholder-gray-400"
                        value="{{ old('studentnumber') }}">
                </div>

                <!-- Two Column Layout -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- First Name -->
                        <div>
                            <label for="firstname" class="block text-sm font-semibold text-gray-700">First Name</label>
                            <input id="firstname" name="firstname" type="text" required autocomplete="firstname" oninput="generateEmail()"
                                class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-red-400 focus:border-red-500 transition px-4 py-2 bg-white placeholder-gray-400"
                                value="{{ old('firstname') }}">
                        </div>

                        <!-- Middle Name -->
                        <div>
                            <label for="middlename" class="block text-sm font-semibold text-gray-700">Middle Name</label>
                            <input id="middlename" name="middlename" type="text" autocomplete="middlename" oninput="generateEmail()"
                                class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-red-400 focus:border-red-500 transition px-4 py-2 bg-white placeholder-gray-400"
                                value="{{ old('middlename') }}">
                        </div>

                        <!-- Contact Number -->
                        <div>
                            <label for="mobilenumber" class="block text-sm font-semibold text-gray-700">Contact Number</label>
                            <input id="mobile_no" name="mobile_no" type="text" required autocomplete="mobilenumber"
                                class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-red-400 focus:border-red-500 transition px-4 py-2 bg-white placeholder-gray-400"
                                value="{{ old('mobilenumber') }}">
                        </div>

                        <!-- Course -->
                        <div>
                            <label for="course" class="block text-sm font-semibold text-gray-700">Course</label>
                            <select id="course" name="course" required
                                class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-red-400 focus:border-red-500 transition px-4 py-2 bg-white placeholder-gray-400">
                                <option value="" disabled selected>Select your course</option>
                                <option value="AIS" {{ old('course') == 'AIS' ? 'selected' : '' }}>Associate in Information System</option>
                                <option value="BSIS" {{ old('course') == 'BSIS' ? 'selected' : '' }}>Bachelor of Science in Information System</option>
                            </select>
                        </div>

                        <!-- Year -->
                        <div>
                            <label for="year" class="block text-sm font-semibold text-gray-700">Year</label>
                            <select id="year" name="year" required
                                class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-red-400 focus:border-red-500 transition px-4 py-2 bg-white placeholder-gray-400">
                                <option value="" disabled selected>Select your year</option>
                                <option value="1" {{ old('year') == '1' ? 'selected' : '' }}>1st Year</option>
                                <option value="2" {{ old('year') == '2' ? 'selected' : '' }}>2nd Year</option>
                                <option value="3" {{ old('year') == '3' ? 'selected' : '' }}>3rd Year</option>
                                <option value="4" {{ old('year') == '4' ? 'selected' : '' }}>4th Year</option>
                            </select>
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                            <input id="password" name="password" type="password" required autocomplete="new-password"
                                class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-red-400 focus:border-red-500 transition px-4 py-2 bg-white placeholder-gray-400">
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Last Name -->
                        <div>
                            <label for="lastname" class="block text-sm font-semibold text-gray-700">Last Name</label>
                            <input id="lastname" name="lastname" type="text" required autocomplete="lastname" oninput="generateEmail()"
                                class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-red-400 focus:border-red-500 transition px-4 py-2 bg-white placeholder-gray-400"
                                value="{{ old('lastname') }}">
                        </div>

                        <!-- Suffix -->
                        <div>
                            <label for="suffix" class="block text-sm font-semibold text-gray-700">Suffix</label>
                            <input id="suffix" name="suffix" type="text" autocomplete="suffix"
                                class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-red-400 focus:border-red-500 transition px-4 py-2 bg-white placeholder-gray-400"
                                value="{{ old('suffix') }}">
                        </div>

                        <!-- NPC Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700">NPC Email</label>
                            <input id="email" name="email" type="email" required autocomplete="username" 
                                class="mt-1 block w-full rounded-lg border border-gray-300 bg-gray-50 shadow-sm focus:ring-2 focus:ring-red-400 focus:border-red-500 transition px-4 py-2 placeholder-gray-400"
                                value="{{ old('email') }}">
                        </div>

                        <!-- Major -->
                        <div>
                            <label for="major" class="block text-sm font-semibold text-gray-700">Major</label>
                            <select id="major" name="major" required
                                class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-red-400 focus:border-red-500 transition px-4 py-2 bg-white placeholder-gray-400">
                                <option value="" disabled selected>Select your major</option>
                                <option value="NA" {{ old('major') == 'NA' ? 'selected' : '' }}>N/A</option>
                            </select>
                        </div>

                        <!-- Section -->
                        <div>
                            <label for="section" class="block text-sm font-semibold text-gray-700">Section</label>
                            <select id="section" name="section" required
                                class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-red-400 focus:border-red-500 transition px-4 py-2 bg-white placeholder-gray-400">
                                <option value="" disabled selected>Select your section</option>
                                <option value="A" {{ old('section') == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ old('section') == 'B' ? 'selected' : '' }}>B</option>
                                <option value="C" {{ old('section') == 'C' ? 'selected' : '' }}>C</option>
                                <option value="D" {{ old('section') == 'D' ? 'selected' : '' }}>D</option>
                            </select>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Confirm Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                                class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-red-400 focus:border-red-500 transition px-4 py-2 bg-white placeholder-gray-400">
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end mt-6 space-x-5">
                    <a class="underline text-sm text-gray-600 hover:text-red-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" href="{{ route('login') }}">
                        Already registered?
                    </a>
                    <button type="submit" class="py-2 px-6 bg-red-600 hover:bg-red-700 text-sm font-semibold rounded-lg text-white transition shadow">
                        Register
                    </button>
                </div>
            </form>
            @if ($errors->any())
    <div class="mb-4 text-sm text-red-600">
        <ul>
            @foreach ($errors->all() as $error)
                <li>• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        </div>
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
