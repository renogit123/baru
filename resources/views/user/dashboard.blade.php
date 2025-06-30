<x-user-layout>
    <div class="max-w-3xl mx-auto p-6 bg-white/10 shadow rounded text-white">
        <h2 class="font-semibold text-xl mb-4">👋 Selamat Datang, {{ Auth::user()->name }}!</h2>
        <p class="mb-6 text-white/80">Silakan lengkapi data biodata Anda dan daftar pelatihan yang tersedia.</p>

        <div class="flex flex-col sm:flex-row gap-4">
            {{-- Tombol Biodata --}}
            <a href="{{ route('user.biodata.form') }}"
               class="inline-block px-5 py-2 bg-yellow-500 text-sky-900 font-semibold rounded hover:bg-yellow-400 transition text-center">
                📋 Lengkapi Biodata
            </a>

            {{-- Tombol Pelatihan --}}
            <a href="{{ route('user.pelatihan.index') }}"
               class="inline-block px-5 py-2 bg-yellow-500 text-sky-900 font-semibold rounded hover:bg-yellow-400 transition text-center">
                📅 Lihat Jadwal Pelatihan
            </a>
            <a href="{{ route('sertifikat.generate', auth()->user()->id) }}" target="_blank"
   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
   Unduh Sertifikat
</a>

        </div>
    </div>
</x-user-layout>
