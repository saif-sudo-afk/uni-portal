<x-guest-layout :mono="false">
    <div class="min-h-[80vh] flex items-center justify-center px-6 py-12 bg-white">
        <div class="w-full max-w-md border border-slate-200 rounded-xl p-6 shadow-sm">
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

        <!-- Role -->
        <div class="mt-4">
            <x-input-label for="role" value="Role" />
            <select id="role" name="role" class="mt-1 block w-full rounded-md border-gray-300 focus:border-sky-500 focus:ring-sky-500">
                <option value="student" {{ old('role', 'student') === 'student' ? 'selected' : '' }}>Student</option>
                <option value="professor" {{ old('role') === 'professor' ? 'selected' : '' }}>Professor</option>
                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Role PIN (required for professor/admin) -->
        <div class="mt-4">
            <x-input-label for="role_pin" value="Role PIN" />
            <x-text-input id="role_pin" class="block mt-1 w-full" type="password" name="role_pin" />
            <x-input-error :messages="$errors->get('role_pin')" class="mt-2" />
            <p class="text-xs text-gray-500 mt-1">Required if you select Professor or Admin.</p>
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

                <div class="flex items-center justify-between mt-4">
                    <a class="underline text-sm text-sky-700 hover:text-sky-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-primary-button>
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
