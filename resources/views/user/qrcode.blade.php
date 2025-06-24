<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">QR Code Kehadiran</h2>
    </x-slot>

    <div class="p-6 bg-white shadow rounded text-center">
        <h3 class="text-lg font-semibold mb-4">Tunjukkan QR Code ini ke Admin</h3>

        @if(session('error'))
            <div class="text-red-600 mb-4">{{ session('error') }}</div>
        @else
            <div class="mb-6">
                {!! QrCode::size(250)->generate($register->id) !!}
            </div>
            <p class="text-gray-600">ID Kehadiran: <strong>{{ $register->id }}</strong></p>
            <p class="text-gray-500 text-sm mt-2">QR ini hanya untuk pelatihan: <br><strong>{{ $register->jadwal->judul ?? '-' }}</strong></p>
        @endif
    </div>
</x-app-layout>
