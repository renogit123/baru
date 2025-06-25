<section>
    <header class="mb-6">
        <h2 class="text-xl font-semibold text-white">
            {{ __('Ganti Password') }}
        </h2>
        <p class="mt-1 text-sm text-white/80">
            {{ __('Gunakan password panjang dan acak untuk keamanan akun Anda.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <!-- Password Lama -->
        <div>
            <label for="update_password_current_password" class="block text-sm font-medium text-white">Password Saat Ini</label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                   class="w-full mt-1 px-4 py-2 rounded-lg bg-white/90 text-gray-900 focus:ring-yellow-400 focus:outline-none">
            @if ($errors->updatePassword->get('current_password'))
                <span class="text-red-200 text-xs">{{ $errors->updatePassword->first('current_password') }}</span>
            @endif
        </div>

        <!-- Password Baru -->
        <div>
            <label for="update_password_password" class="block text-sm font-medium text-white">Password Baru</label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                   class="w-full mt-1 px-4 py-2 rounded-lg bg-white/90 text-gray-900 focus:ring-yellow-400 focus:outline-none">
            @if ($errors->updatePassword->get('password'))
                <span class="text-red-200 text-xs">{{ $errors->updatePassword->first('password') }}</span>
            @endif
        </div>

        <!-- Konfirmasi Password Baru -->
        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-medium text-white">Konfirmasi Password</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                   class="w-full mt-1 px-4 py-2 rounded-lg bg-white/90 text-gray-900 focus:ring-yellow-400 focus:outline-none">
            @if ($errors->updatePassword->get('password_confirmation'))
                <span class="text-red-200 text-xs">{{ $errors->updatePassword->first('password_confirmation') }}</span>
            @endif
        </div>

        <!-- Tombol Simpan -->
        <div class="flex items-center gap-4">
            <button type="submit"
                    class="py-2 px-6 bg-yellow-400 text-blue-900 font-semibold rounded-full hover:bg-yellow-300 transition">
                Simpan
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-white/80">
                    Password berhasil diperbarui.
                </p>
            @endif
        </div>
    </form>
</section>
