<section class="space-y-6">
    <header class="mb-4">
        <h2 class="text-xl font-semibold text-white">
            {{ __('Hapus Akun') }}
        </h2>
        <p class="mt-1 text-sm text-white/80">
            {{ __('Setelah akun Anda dihapus, semua data terkait akan terhapus permanen. Unduh data yang ingin Anda simpan terlebih dahulu.') }}
        </p>
    </header>

    <!-- Tombol Buka Modal -->
    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="py-2 px-6 bg-red-600 text-white font-semibold rounded-full hover:bg-red-500 transition"
    >
        {{ __('Hapus Akun') }}
    </button>

    <!-- Modal Konfirmasi -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="POST" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-semibold text-gray-900 mb-2">
                {{ __('Apakah Anda yakin ingin menghapus akun?') }}
            </h2>

            <p class="text-sm text-gray-700">
                {{ __('Setelah akun dihapus, semua data dan sumber daya akan terhapus secara permanen. Masukkan password Anda untuk konfirmasi.') }}
            </p>

            <!-- Input Password -->
            <div class="mt-4">
                <label for="password" class="sr-only">Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    placeholder="Password"
                    class="w-full mt-1 px-4 py-2 rounded-lg bg-gray-100 text-gray-900 focus:outline-none focus:ring-2 focus:ring-red-400"
                />
                @if ($errors->userDeletion->get('password'))
                    <span class="text-red-600 text-sm mt-2">{{ $errors->userDeletion->first('password') }}</span>
                @endif
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-6 flex justify-end">
                <button type="button"
                        x-on:click="$dispatch('close')"
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition">
                    {{ __('Batal') }}
                </button>

                <button type="submit"
                        class="ml-3 px-4 py-2 bg-red-600 text-white font-semibold rounded-md hover:bg-red-500 transition">
                    {{ __('Hapus Akun') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
