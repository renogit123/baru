<x-admin-layout>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-white">📋 Detail Jadwal: {{ $jadwal->judul }}</h2>
        <a href="{{ route('admin.jadwal-pelatihan.index') }}" class="text-sm text-white/70 hover:underline">⬅️ Kembali</a>
    </div>

    <div class="p-6 bg-white/5 border border-white/10 rounded shadow backdrop-blur text-white space-y-6">
        <div>
            <h3 class="text-lg font-bold">🗓️ Informasi Pelatihan</h3>
            <p><strong>Tanggal:</strong> {{ $jadwal->tgl_mulai }} s/d {{ $jadwal->tgl_selesai }}</p>
            <p><strong>Provinsi:</strong> {{ $jadwal->provinsi->nama ?? '-' }}</p>
            <p><strong>Kabupaten:</strong> {{ $jadwal->kabupatenkota->nama ?? '-' }}</p>
            <p><strong>Status:</strong>
                @if($jadwal->status)
                    <span class="text-green-400 font-semibold">Aktif</span>
                @else
                    <span class="text-red-400 font-semibold">Tidak Aktif</span>
                @endif
            </p>
        </div>

<form method="GET" action="{{ route('admin.jadwal-pelatihan.showHadir', $jadwal->id) }}" class="mb-4">
<form method="GET" action="{{ route('admin.jadwal-pelatihan.showHadir', $jadwal->id) }}" class="mb-4">
    <div class="flex items-center space-x-2">
        <label for="tanggal" class="text-white text-sm">📅 Filter Tanggal:</label>
        <input type="date" name="tanggal" id="tanggal"
               value="{{ request('tanggal', \Carbon\Carbon::today()->toDateString()) }}"
               class="text-sm px-3 py-1 rounded border border-white/20 bg-white/10 text-white placeholder:text-white/40">

        <button type="submit"
                class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-500 text-sm">
            🔍 Tampilkan
        </button>

        @if(request('tanggal'))
            <a href="{{ route('admin.jadwal-pelatihan.showHadir', $jadwal->id) }}"
               class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-500 text-sm">
                🔄 Reset
            </a>
        @endif
    </div>
</form>

        <div class="flex justify-between items-center mb-4">
            <div class="flex gap-2">
                <a href="{{ route('admin.jadwal.export-nilai', ['id' => $jadwal->id, 'tanggal' => request('tanggal', date('Y-m-d'))]) }}"
                   class="px-3 py-1 bg-blue-600 hover:bg-blue-500 text-white text-xs rounded shadow">
                   📥 Download PDF Daftar Hadir
                </a>
                <a href="{{ route('admin.jadwal.export-excel', ['id' => $jadwal->id, 'tanggal' => request('tanggal', date('Y-m-d'))]) }}"
                   class="px-3 py-1 bg-green-600 hover:bg-green-500 text-white text-xs rounded shadow">
                   📊 Download Excel Nilai Pre Test dan Post test
                </a>
            </div>
        </div>

        <div>
            <h3 class="text-lg font-bold">👥 Daftar Peserta</h3>

            @if(session('success'))
                <div class="text-green-400 bg-green-900/20 border border-green-500/30 p-3 rounded">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <table class="min-w-full table-auto border border-white/10 divide-y divide-white/10 text-sm">
                <thead class="bg-white/10 text-white/80">
                    <tr>
                        <th class="px-4 py-2 text-left">Nama</th>
                        <th class="px-4 py-2 text-left">NIK</th>
                        <th class="px-4 py-2 text-left">Status Pendaftaran</th>
                    </tr>
                </thead>
                <tbody>
                    @php $filtered = $jadwal->pendaftars->filter(function($p) { return !$p->absensis || $p->absensis->where('tanggal_absen', request('tanggal', date('Y-m-d')))->isNotEmpty(); }); @endphp
                    @forelse ($filtered as $pendaftar)
                        <tr class="hover:bg-white/10">
                            <td class="px-4 py-2">{{ $pendaftar->user->biodata->nama ?? $pendaftar->user->name }}</td>
                            <td class="px-4 py-2">{{ $pendaftar->user->biodata->nik ?? '-' }}</td>
                            <td class="px-4 py-2">
                                @if($pendaftar->status_peserta === 'approved')
                                    <div class="flex gap-2 items-center">
                                        <span class="text-green-400 font-semibold">✅ Disetujui</span>
                                        <form method="POST" action="{{ route('admin.pelatihan.batal', $pendaftar->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <button class="text-yellow-300 hover:underline" onclick="return confirm('Yakin ingin membatalkan persetujuan?')">
                                                🔁 Batalkan
                                            </button>
                                        </form>
                                    </div>
                                @elseif($pendaftar->status_peserta === 'rejected')
                                    <span class="text-red-400 font-semibold">❌ Ditolak</span>
                                @else
                                    <div class="flex gap-2">
                                        <form method="POST" action="{{ route('admin.pelatihan.acc', $pendaftar->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <button class="text-green-300 hover:underline" onclick="this.disabled=true; this.innerText='Menyetujui...'; this.form.submit();">
                                                ✅ ACC
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.pelatihan.reject', $pendaftar->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <button class="text-red-300 hover:underline" onclick="this.disabled=true; this.innerText='Menolak...'; this.form.submit();">
                                                ❌ Tolak
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-white/50 py-4">Belum ada peserta.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
