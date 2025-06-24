<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Tiket Pelatihan</h2>
    </x-slot>

    <div class="p-6 bg-white shadow rounded">
        <h3 class="text-lg font-bold mb-4">Pelatihan: {{ $register->jadwal->judul }}</h3>
        <p>Nama: {{ Auth::user()->biodata->nama ?? Auth::user()->name }}</p>
        <p>NIK: {{ Auth::user()->biodata->nik ?? '-' }}</p>

        <div class="mt-4">
            <h4 class="font-semibold">QR Code Kehadiran:</h4>
            {!! QrCode::size(200)->generate($register->id) !!}
            <p class="text-sm text-gray-500 mt-2">Tunjukkan QR ini ke petugas saat hadir</p>
        </div>
    </div>
</x-app-layout>
