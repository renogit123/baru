<section>
    <header class="mb-6">
        <h2 class="text-xl font-semibold text-white">
            {{ __('Informasi Profil') }}
        </h2>
        <p class="mt-1 text-sm text-white/80">
            {{ __("Perbarui nama dan alamat email Anda.") }}
        </p>
    </header>

    <!-- Form kirim ulang verifikasi -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Form update profil -->
    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <!-- Nama -->
        <div>
            <label for="name" class="block text-sm font-medium text-white">Nama</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}"
                   required autofocus autocomplete="name"
                   class="w-full mt-1 px-4 py-2 rounded-lg bg-white/90 text-gray-900 focus:ring-yellow-400 focus:outline-none">
            @error('name')
                <span class="text-red-200 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-white">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}"
                   required autocomplete="username"
                   class="w-full mt-1 px-4 py-2 rounded-lg bg-white/90 text-gray-900 focus:ring-yellow-400 focus:outline-none">
            @error('email')
                <span class="text-red-200 text-xs">{{ $message }}</span>
            @enderror

            <!-- Verifikasi ulang email -->
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 text-sm text-white/90">
                    <p>
                        Email Anda belum terverifikasi.

                        <button form="send-verification"
                                class="underline text-yellow-300 hover:text-yellow-200 font-medium">
                            Klik di sini untuk mengirim ulang email verifikasi.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-1 font-medium text-green-200">
                            Tautan verifikasi baru telah dikirim.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Tombol Simpan -->
        <div class="flex items-center gap-4">
            <button type="submit"
                    class="py-2 px-6 bg-yellow-400 text-blue-900 font-semibold rounded-full hover:bg-yellow-300 transition">
                Simpan
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-white/80"
                >Berhasil disimpan.</p>
            @endif
        </div>
    </form>
</section>
