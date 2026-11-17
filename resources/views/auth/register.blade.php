<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div style="margin-bottom: 15px;">
            <label for="name" style="display:block; color: #3e2723; font-weight: bold; margin-bottom: 5px;">Nama Lengkap</label>
            <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" 
                   style="width: 100%; padding: 10px; border: 1px solid #d7ccc8; border-radius: 4px; box-sizing: border-box;">
            <x-input-error :messages="$errors->get('name')" class="mt-2" style="color: red; font-size: 12px;" />
        </div>

        <!-- Email Address -->
        <div style="margin-bottom: 15px;">
            <label for="email" style="display:block; color: #3e2723; font-weight: bold; margin-bottom: 5px;">Email</label>
            <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                   style="width: 100%; padding: 10px; border: 1px solid #d7ccc8; border-radius: 4px; box-sizing: border-box;">
            <x-input-error :messages="$errors->get('email')" class="mt-2" style="color: red; font-size: 12px;" />
        </div>

        <!-- Password -->
        <div style="margin-bottom: 15px;">
            <label for="password" style="display:block; color: #3e2723; font-weight: bold; margin-bottom: 5px;">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   style="width: 100%; padding: 10px; border: 1px solid #d7ccc8; border-radius: 4px; box-sizing: border-box;">
            <x-input-error :messages="$errors->get('password')" class="mt-2" style="color: red; font-size: 12px;" />
        </div>

        <!-- Confirm Password -->
        <div style="margin-bottom: 15px;">
            <label for="password_confirmation" style="display:block; color: #3e2723; font-weight: bold; margin-bottom: 5px;">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   style="width: 100%; padding: 10px; border: 1px solid #d7ccc8; border-radius: 4px; box-sizing: border-box;">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" style="color: red; font-size: 12px;" />
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
            <a href="{{ route('login') }}" style="color: #8b5e3c; text-decoration: underline; font-size: 14px;">
                Sudah punya akun?
            </a>

            <button type="submit" style="background-color: #5d4037; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
                REGISTER
            </button>
        </div>
    </form>
</x-guest-layout>