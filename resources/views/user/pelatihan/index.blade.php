<x-user-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-yellow-300">📅 Jadwal Pelatihan</h2>
    </x-slot>

    <div class="p-6 bg-sky-950 text-white rounded-xl shadow ring-1 ring-white/10 space-y-6">

        <div>
            <a href="{{ route('user.dashboard') }}"
               class="inline-block px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded shadow transition">
                ← Kembali ke Dashboard
            </a>
        </div>

        <h3 class="text-lg font-semibold text-yellow-400">Daftar Pelatihan yang Tersedia</h3>

        {{-- Notifikasi --}}
        @if(session('success'))
            <div class="text-green-300 bg-green-900/40 px-4 py-2 rounded border border-green-600">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="text-red-300 bg-red-900/40 px-4 py-2 rounded border border-red-600">
                {{ session('error') }}
            </div>
        @endif

        @php
            $userId = Auth::id();
        @endphp

        {{-- List Pelatihan --}}
        @forelse ($jadwals as $jadwal)
            @php
                $register = $jadwal->registers->firstWhere('user_id', $userId);
            @endphp

            <div class="border border-white/10 p-4 rounded bg-sky-900 shadow-inner">
                <h4 class="text-lg font-bold text-white">{{ $jadwal->judul }}</h4>
                <p class="text-white/80">🗓️ Tanggal: {{ $jadwal->tgl_mulai }} s/d {{ $jadwal->tgl_selesai }}</p>
                <p class="text-white/60 text-sm">💰 Pembiayaan: {{ $jadwal->pembiayaan }} | 🏫 Kelas: {{ $jadwal->kelas }}</p>
                
                {{-- Tambahan Lokasi --}}
                <p class="text-white/60 text-sm">📍 Kabupaten/Kota: {{ $jadwal->kabupatenkota->nama ?? '-' }}</p>
                <p class="text-white/60 text-sm">🗺️ Provinsi: {{ $jadwal->provinsi->nama ?? '-' }}</p>

                @if($register)
                    @if($register->status_peserta === 'pending')
                        <p class="text-yellow-400 font-semibold mt-2">⌛ Status: Menunggu Persetujuan</p>
                    @elseif($register->status_peserta === 'approved')
                        <p class="text-green-400 font-semibold mt-2">✅ Kamu telah disetujui sebagai peserta</p>
                        <a href="{{ route('user.qrcode') }}"
                           class="inline-block mt-3 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded shadow">
                            🎫 Tampilkan QR Code
                        </a>
                    @elseif($register->status_peserta === 'rejected')
                        <form method="POST" action="{{ route('user.pelatihan.daftar', $jadwal->id) }}">
                            @csrf
                            <button type="submit"
                                    class="mt-3 bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 rounded shadow">
                                🔁 Daftar Ulang
                            </button>
                        </form>
                    @endif
                @else
                    <form method="POST" action="{{ route('user.pelatihan.daftar', $jadwal->id) }}">
                        @csrf
                        <button type="submit"
                                class="mt-3 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
                            📥 Daftar
                        </button>
                    </form>
                @endif
            </div>
        @empty
            <p class="text-white/60 italic">Belum ada pelatihan tersedia saat ini.</p>
        @endforelse
    </div>
</x-user-layout>
