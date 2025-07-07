<x-admin-layout>

    <div class="bg-gradient-to-r from-yellow-400/20 via-yellow-300/10 to-yellow-200/5 p-6 rounded-xl shadow text-white mb-6">
    <h1 class="text-3xl font-extrabold tracking-tight drop-shadow mb-2">
        🔰 Selamat Datang, {{ Auth::user()->name }}
    </h1>
    <p class="text-white/80 text-lg">Anda login sebagai <span class="font-bold text-yellow-300">Admin</span> di Sistem Informasi <span class="font-semibold text-yellow-100">Kementerian Dalam Negeri - Kota Malang</span>.</p>
</div>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    {{-- Total Pengguna --}}
    <div class="bg-white/10 backdrop-blur rounded-xl p-4 shadow text-center">
        <div class="text-4xl font-bold text-yellow-300">{{ $jumlahUser }}</div>
        <div class="text-sm text-white/70 mt-1">Total Pengguna</div>
    </div>

    {{-- Biodata Masuk --}}
    <div class="bg-white/10 backdrop-blur rounded-xl p-4 shadow text-center">
        <div class="text-4xl font-bold text-yellow-300">{{ $jumlahBiodata }}</div>
        <div class="text-sm text-white/70 mt-1">Biodata Terisi</div>
    </div>

    {{-- Pelatihan --}}
    <div class="bg-white/10 backdrop-blur rounded-xl p-4 shadow text-center">
        <div class="text-4xl font-bold text-yellow-300">{{ $jumlahPelatihan }}</div>
        <div class="text-sm text-white/70 mt-1">Pelatihan</div>
    </div>



<div class="bg-white/5 backdrop-blur-lg rounded-xl p-4 shadow text-white">
    <h2 class="text-lg font-bold mb-2">📢 Informasi Sistem</h2>
    <ul class="list-disc list-outside text-white/80 space-y-1 text-sm text-justify pl-5">
        <li>Sistem terakhir diperbarui: 
            <span class="font-semibold text-yellow-300">{{ now()->format('d F Y') }}</span>
        </li>
        <li>Gunakan fitur scan QR untuk absensi peserta.</li>
        <li>Admin dapat menambahkan pelatihan baru di menu "Pelatihan".</li>
    </ul>
</div>


</x-admin-layout>
