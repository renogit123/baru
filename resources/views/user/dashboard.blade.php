<x-user-layout>
    <div class="max-w-7xl mx-auto px-6 py-10">
        <div class="bg-white/10 rounded-2xl shadow-xl ring-1 ring-white/10 backdrop-blur-md p-8">

            {{-- Header --}}
            <div class="mb-8 text-center">
                <h2 class="text-3xl font-extrabold tracking-tight mb-2">👋 Selamat Datang, {{ Auth::user()->name }}!</h2>
                <p class="text-white/70 text-lg max-w-2xl mx-auto">
                    Lengkapi data biodata Anda, daftar pelatihan, dan dapatkan sertifikat resmi dari Kemendagri.
                </p>
            </div>

            {{-- Informasi Penting --}}
            <div class="bg-yellow-500/90 text-sky-900 px-6 py-4 rounded-md font-semibold shadow text-center mb-10">
                🎯 Pastikan biodata Anda lengkap & sudah disetujui untuk bisa mendaftar pelatihan dan mengunduh sertifikat.
            </div>

            {{-- Aksi Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                {{-- Biodata --}}
                <a href="{{ route('user.biodata.form') }}"
                   class="p-6 bg-yellow-500 hover:bg-yellow-400 rounded-xl text-sky-900 font-bold shadow transition transform hover:scale-105 text-center">
                    📋 Lengkapi Biodata
                </a>

                {{-- Pelatihan --}}
                <a href="{{ route('user.pelatihan.index') }}"
                   class="p-6 bg-yellow-500 hover:bg-yellow-400 rounded-xl text-sky-900 font-bold shadow transition transform hover:scale-105 text-center">
                    📅 Lihat Pelatihan
                </a>

                {{-- Sertifikat --}}
                @php $biodata = Auth::user()->biodata; @endphp
                @if($biodata && $biodata->is_approved)
                    <a href="{{ route('sertifikat.generate', auth()->id()) }}" target="_blank"
                       class="p-6 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow transition transform hover:scale-105 text-center">
                        🧾 Unduh Sertifikat
                    </a>
                @elseif($biodata)
                    <div class="p-6 bg-gray-700 text-white text-sm font-semibold rounded-xl shadow text-center">
                        🕒 Menunggu ACC Admin
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-user-layout>
