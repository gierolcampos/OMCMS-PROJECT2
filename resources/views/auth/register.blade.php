<x-guest-layout>
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-lg">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mt-4">
                <x-input-label for="firstname" :value="__('First Name')" />
                <x-text-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" required autofocus autocomplete="firstname" oninput="generateEmail()" />
                <x-input-error :messages="$errors->get('firstname')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="lastname" :value="__('Last Name')" />
                <x-text-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" required autofocus autocomplete="lastname" oninput="generateEmail()" />
                <x-input-error :messages="$errors->get('lastname')" class="mt-2" />
            </div>      
            
            <div class="mt-4">
                <x-input-label for="studentnumber" :value="__('Student Number')" />
                <x-text-input id="studentnumber" class="block mt-1 w-full" type="text" name="studentnumber" :value="old('studentnumber')" required autofocus autocomplete="studentnumber" oninput="generateEmail()" maxlength="6" pattern="[0-9]{6}" placeholder="Student Number" />
                
                <x-input-error :messages="$errors->get('studentnumber')" class="mt-2" />
            </div>        


            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" readonly />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ms-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <script>
        function generateEmail() {
            const firstname = document.getElementById('firstname').value.trim();
            const lastname = document.getElementById('lastname').value.trim().toLowerCase();
            const studentnumber = document.getElementById('studentnumber').value.trim();
            
            if (firstname && lastname && studentnumber) {
                // Get first letter of each word in first name
                const firstLetters = firstname.split(' ')
                    .filter(word => word.length > 0)
                    .map(word => word[0].toLowerCase())
                    .join('');
                
                // Construct email
                const email = firstLetters + lastname + studentnumber + '@navotaspolytechniccollege.edu.ph';
                document.getElementById('email').value = email;
            }
        }

        // Initialize email if values are pre-filled
        window.onload = generateEmail;
    </script>
</x-guest-layout>
