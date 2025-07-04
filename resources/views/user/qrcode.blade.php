<x-user-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white">QR Code Kehadiran</h2>
        <div>
            <a href="{{ route('user.dashboard') }}"
               class="inline-block px-4 py-2 bg-yellow-600 transparent hover:bg-yellow-700 text-white rounded shadow transition">
                Kembali ke Dashboard
            </a>
        </div>
    </x-slot>


    <div class="p-6 bg-white shadow rounded text-center">
        <h3 class="text-lg font-semibold mb-4">Tunjukkan QR Code ini ke Admin</h3>

        @if(session('error'))
            <div class="text-red-600 mb-4">{{ session('error') }}</div>
        @else
            {{-- Centered QR Code --}}
            <div class="flex justify-center mb-6">
                {!! QrCode::size(250)->generate($register->id) !!}
            </div>

            <p class="text-gray-600">ID Kehadiran: <strong>{{ $register->id }}</strong></p>
            <p class="text-gray-500 text-sm mt-2">
                QR ini hanya untuk pelatihan: <br>
                <strong>{{ $register->jadwal->judul ?? '-' }}</strong>
            </p>
        @endif
    </div>
</x-user-layout>
