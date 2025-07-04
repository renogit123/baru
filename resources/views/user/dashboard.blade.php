<x-user-layout>
    <div class="max-w-6xl mx-auto px-6 py-10 space-y-12">

        {{-- HEADER --}}
        <div class="space-y-3 animate-fade-in-up">
            <h1 class="text-4xl font-extrabold text-yellow-300 drop-shadow tracking-wide">
                👋 Halo, {{ Auth::user()->name }}!
            </h1>
            <p class="text-white/80 leading-relaxed max-w-3xl text-lg">
                Selamat datang di Sistem 
                <span class="text-yellow-300 font-extrabold tracking-wide">Kementerian Dalam Negeri Kota Malang</span>.
                Lengkapi <strong>biodata</strong> Anda, daftar <strong>pelatihan</strong>, dan unduh <strong>sertifikat digital</strong> Anda.
            </p>
        </div>

        {{-- INFO STRIP --}}
        <div class="bg-yellow-400/90 text-sky-900 text-center font-semibold py-3 rounded shadow ring-1 ring-yellow-100 animate-pulse-slow">
            🎯 <span class="tracking-wide">Pastikan biodata Anda lengkap & telah disetujui untuk dapat mendaftar pelatihan dan mengunduh sertifikat.</span>
        </div>

        {{-- KARTU MENU UTAMA --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-fade-in delay-300">
            {{-- Biodata --}}
            <a href="{{ route('user.biodata.form') }}"
               class="p-6 bg-yellow-400 hover:bg-yellow-300 text-sky-900 font-bold rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all text-center space-y-2">
                <div class="text-4xl">📋</div>
                <div>Lengkapi Biodata</div>
            </a>

            {{-- Pelatihan --}}
            <a href="{{ route('user.pelatihan.index') }}"
               class="p-6 bg-yellow-400 hover:bg-yellow-300 text-sky-900 font-bold rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all text-center space-y-2">
                <div class="text-4xl">📅</div>
                <div>Lihat Pelatihan</div>
            </a>

            {{-- Sertifikat --}}
            @php $biodata = Auth::user()->biodata; @endphp
            @if($biodata && $biodata->is_approved)
                <a href="{{ route('sertifikat.generate', auth()->id()) }}" target="_blank"
                   class="p-6 bg-yellow-400 hover:bg-yellow-300 text-sky-900 font-bold rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all text-center space-y-2">
                    <div class="text-4xl">🧾</div>
                    <div>Unduh Sertifikat</div>
                </a>
            @elseif($biodata)
                <div class="p-6 bg-gray-800/70 text-white rounded-2xl text-center shadow-inner space-y-2">
                    <div class="text-3xl">⏳</div>
                    <div class="text-sm font-semibold">Menunggu ACC Admin</div>
                </div>
            @endif
        </div>
    </div>
</x-user-layout>
