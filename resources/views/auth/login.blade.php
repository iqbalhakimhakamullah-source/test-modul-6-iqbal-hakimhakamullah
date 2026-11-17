<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div style="margin-bottom: 15px;">
            <label for="email" style="display:block; color: #3e2723; font-weight: bold; margin-bottom: 5px;">Email</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" 
                   style="width: 100%; padding: 10px; border: 1px solid #d7ccc8; border-radius: 4px; box-sizing: border-box;">
            <x-input-error :messages="$errors->get('email')" class="mt-2" style="color: red; font-size: 12px;" />
        </div>

        <!-- Password -->
        <div style="margin-bottom: 15px;">
            <label for="password" style="display:block; color: #3e2723; font-weight: bold; margin-bottom: 5px;">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   style="width: 100%; padding: 10px; border: 1px solid #d7ccc8; border-radius: 4px; box-sizing: border-box;">
            <x-input-error :messages="$errors->get('password')" class="mt-2" style="color: red; font-size: 12px;" />
        </div>

        <!-- Remember Me -->
        <div style="margin-bottom: 15px; display: flex; align-items: center;">
            <input id="remember_me" type="checkbox" name="remember" style="margin-right: 8px;">
            <label for="remember_me" style="color: #3e2723; font-size: 14px;">Ingat saya</label>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="color: #8b5e3c; text-decoration: underline; font-size: 14px;">
                    Lupa password?
                </a>
            @endif

            <button type="submit" style="background-color: #5d4037; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
                LOG IN
            </button>
        </div>
    </form>
</x-guest-layout>