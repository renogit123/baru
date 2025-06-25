<x-user-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Jadwal Pelatihan</h2>
    </x-slot>

    <div class="p-6 bg-white shadow rounded space-y-4">
        <h3 class="text-lg font-semibold mb-4">Daftar Pelatihan yang Tersedia</h3>

        {{-- Pesan Sukses/Error --}}
        @if(session('success'))
            <div class="text-green-600 mb-3">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="text-red-600 mb-3">{{ session('error') }}</div>
        @endif

        @php
            $userId = Auth::id();
        @endphp

        @forelse ($jadwals as $jadwal)
            @php
                $register = $jadwal->registers->firstWhere('user_id', $userId);
            @endphp
            <div class="border p-4 rounded mb-4">
                <h4 class="text-lg font-bold">{{ $jadwal->judul }}</h4>
                <p class="text-gray-600">Tanggal: {{ $jadwal->tgl_mulai }} s/d {{ $jadwal->tgl_selesai }}</p>
                <p class="text-sm text-gray-500">Pembiayaan: {{ $jadwal->pembiayaan }} | Kelas: {{ $jadwal->kelas }}</p>

                @if($register)
                    @if($register->status_peserta === 'pending')
                        <p class="text-yellow-600 font-semibold mt-2">Status: Menunggu Persetujuan</p>
                    @elseif($register->status_peserta === 'approved')
                        <p class="text-green-600 font-semibold mt-2">✅ Kamu telah disetujui sebagai peserta</p>
                        <a href="{{ route('user.qrcode') }}"
                           class="inline-block mt-2 bg-indigo-600 hover:bg-indigo-700 text-black px-4 py-2 rounded">
                            🎫 Tampilkan QR Code
                        </a>
                    @endif
                @else
                    <form method="POST" action="{{ route('user.pelatihan.daftar', $jadwal->id) }}">
                        @csrf
                        <button type="submit"
                                class="mt-2 inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                            Daftar
                        </button>
                    </form>
                @endif
            </div>
        @empty
            <p class="text-gray-500">Belum ada pelatihan tersedia saat ini.</p>
        @endforelse
    </div>
</x-user-layout>
