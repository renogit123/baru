<x-user-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-yellow-300">🎫 QR Code Kehadiran</h2>
    </x-slot>

    <div class="p-6 bg-sky-950 text-white rounded-xl shadow ring-1 ring-white/10">

        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('user.dashboard') }}"
               class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded shadow transition">
                ← Kembali ke Dashboard
            </a>
        </div>

        <div class="text-center">
            <h3 class="text-lg font-semibold text-yellow-400 mb-4">Tunjukkan QR Code ini ke Admin saat pelatihan</h3>

            @if(session('error'))
                <div class="text-red-300 bg-red-900/40 px-4 py-2 rounded border border-red-600 mb-4">
                    {{ session('error') }}
                </div>
            @else
                {{-- Centered QR Code --}}
                <div class="flex justify-center mb-6">
                    {!! QrCode::size(250)->generate($register->id) !!}
                </div>

                <p class="text-white text-lg">🆔 ID Kehadiran: <strong>{{ $register->id }}</strong></p>
                <p class="text-white/80 text-sm mt-2">
                    QR ini hanya untuk pelatihan: <br>
                    <strong class="text-yellow-300">{{ $register->jadwal->judul ?? '-' }}</strong>
                </p>
            @endif
        </div>
    </div>
</x-user-layout>
