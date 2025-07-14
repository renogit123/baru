<x-user-layout>
    <div class="max-w-6xl mx-auto px-4 md:px-8 py-10 space-y-14">

        {{-- HEADER --}}
        <div class="space-y-3 text-center md:text-left animate-fade-in-up">
            <h1 class="text-4xl md:text-5xl font-extrabold text-yellow-300 tracking-tight drop-shadow">
                👋 Halo, {{ Auth::user()->name }}!
            </h1>
            <p class="text-white/80 leading-relaxed text-lg max-w-3xl">
                Selamat datang di sistem 
                <span class="text-yellow-300 font-bold">Kementerian Dalam Negeri Kota Malang</span>. 
                Lengkapi biodata Anda, ikuti pelatihan, dan unduh sertifikat digital resmi.
            </p>
        </div>

        {{-- INFO STRIP --}}
        <div class="bg-yellow-400/90 text-sky-900 text-center font-semibold py-3 rounded-xl shadow-md ring-1 ring-yellow-100 animate-pulse-slow">
            🎯 Biodata harus lengkap & disetujui untuk mendaftar pelatihan & unduh sertifikat.
        </div>

        {{-- MENU UTAMA --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-fade-in delay-200">
            {{-- Biodata --}}
            <a href="{{ route('user.biodata.form') }}"
               class="group bg-white/10 backdrop-blur border border-white/10 rounded-2xl shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-1 p-6 text-center space-y-3 hover:bg-yellow-400/90">
                <div class="text-5xl group-hover:scale-110 transition">📋</div>
                <h3 class="text-lg font-bold text-white group-hover:text-sky-900">Lengkapi Biodata</h3>
            </a>

            {{-- Pelatihan --}}
            <a href="{{ route('user.pelatihan.index') }}"
               class="group bg-white/10 backdrop-blur border border-white/10 rounded-2xl shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-1 p-6 text-center space-y-3 hover:bg-yellow-400/90">
                <div class="text-5xl group-hover:scale-110 transition">📅</div>
                <h3 class="text-lg font-bold text-white group-hover:text-sky-900">Lihat Pelatihan</h3>
            </a>

            {{-- Sertifikat --}}
            @php $biodata = Auth::user()->biodata; @endphp
            @if($biodata && $biodata->is_approved)
                <a href="{{ route('sertifikat.generate', auth()->id()) }}" target="_blank"
                   class="group bg-white/10 backdrop-blur border border-white/10 rounded-2xl shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-1 p-6 text-center space-y-3 hover:bg-yellow-400/90">
                    <div class="text-5xl group-hover:scale-110 transition">🧾</div>
                    <h3 class="text-lg font-bold text-white group-hover:text-sky-900">Unduh Sertifikat</h3>
                </a>
            @elseif($biodata)
                <div class="bg-gray-800/60 text-white text-center p-6 rounded-2xl shadow-inner space-y-2">
                    <div class="text-3xl">⏳</div>
                    <p class="text-sm font-semibold">Menunggu ACC Admin</p>
                </div>
            @endif
        </div>

        {{-- INFO PELATIHAN --}}
        <div class="bg-gradient-to-r from-yellow-500/10 to-white/5 border border-yellow-100/20 backdrop-blur-md p-6 rounded-xl shadow-md ring-1 ring-white/10 animate-fade-in">
            <h2 class="text-xl font-bold text-yellow-300 mb-4">📢 Pelatihan Aktif</h2>

            <ul class="space-y-3 text-white/90 text-sm">
                <li class="flex gap-3 items-start">
                    <span class="text-yellow-400 text-lg">📌</span>
                    <div>
                        <strong>Pelatihan Dasar Pemerintahan Desa</strong><br>
                        <span class="text-white/70">15–18 Juli 2025 • Balai Besar Kemendagri Malang</span>
                    </div>
                </li>
                <li class="flex gap-3 items-start">
                    <span class="text-yellow-400 text-lg">📌</span>
                    <div>
                        <strong>Manajemen Keuangan Desa</strong><br>
                        <span class="text-white/70">22–25 Juli 2025 • Zoom Meeting</span>
                    </div>
                </li>
            </ul>

            <div class="mt-5 text-right">
                <a href="{{ route('user.pelatihan.index') }}"
                   class="text-sm text-yellow-300 font-semibold hover:underline">🔍 Lihat semua pelatihan &rarr;</a>
            </div>
        </div>

        {{-- TENTANG APLIKASI --}}
        <div class="bg-white/5 backdrop-blur border border-white/10 p-6 rounded-xl shadow-lg animate-fade-in">
            <h2 class="text-xl font-bold text-yellow-300 mb-3">ℹ️ Tentang Aplikasi</h2>
            <p class="text-sm text-white/80 mb-3">
                Sistem ini dikembangkan oleh <strong>Kementerian Dalam Negeri Kota Malang</strong> untuk mempermudah peserta pelatihan dalam:
            </p>
            <ul class="list-disc pl-5 text-sm text-white/70 space-y-1">
                <li>Melengkapi data pribadi (biodata)</li>
                <li>Mendaftar pelatihan resmi</li>
                <li>Mendapatkan sertifikat digital setelah menyelesaikan pelatihan</li>
            </ul>
        </div>

        {{-- GOOGLE MAPS - BALAI BESAR BINA PEMERINTAHAN DAN DESA --}}
<div class="mt-12 animate-fade-in">
    <h2 class="text-xl font-bold text-yellow-300 mb-4 text-center">
        📍 Lokasi Balai Besar Bina Pemerintahan dan Desa
    </h2>

    <div class="w-full h-[400px] rounded-xl overflow-hidden border border-white/10 shadow-xl">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63219.665731262205!2d112.5368902486328!3d-7.975256999999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7883584d301afb%3A0xee9fdbf353ffc7e5!2sBalai%20Besar%20Bina%20Pemerintahan%20dan%20Desa!5e0!3m2!1sen!2sid!4v1751870087902!5m2!1sen!2sid" 
            width="100%" height="100%" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade"
            class="w-full h-full">
        </iframe>
    </div>

    <div class="text-center mt-4">
        <a href="https://maps.app.goo.gl/ue4tEMKHMCqDGuvh6" target="_blank" 
           class="text-sm text-yellow-300 hover:underline">
            🌐 Buka di Google Maps →
        </a>
    </div>
</div>

{{-- HUBUNGI KAMI --}}
        <div class="bg-yellow-100/10 border border-yellow-300/20 p-6 rounded-xl shadow ring-1 ring-yellow-100/10 animate-fade-in">
            <h2 class="text-xl font-bold text-yellow-300 mb-3">📞 Bantuan & Kontak</h2>
            <p class="text-sm text-white/80 leading-relaxed">
                Jika mengalami kendala, hubungi kami melalui:
            </p>
            <ul class="mt-3 text-sm text-white/90 space-y-1">
                <li>📧 Email: <a href="mailto:support@kemendagri.go.id" class="underline hover:text-yellow-300">support@kemendagri.go.id</a></li>
                <li>☎️ Telepon: (0341) 123456</li>
                <li>🕒 Jam Operasional: Senin–Jumat, 08.00–16.00 WIB</li>
            </ul>
        </div>

    </div>
</x-user-layout>
