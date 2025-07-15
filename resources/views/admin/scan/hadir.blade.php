<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-white">📝 Daftar Kehadiran Peserta</h2>
            <a href="{{ route('admin.jadwal-pelatihan.index') }}"
               class="text-sm text-white/70 hover:underline">⬅ Kembali</a>
        </div>
    </x-slot>

    @php
        $tanggalFix = request('tanggal', \Carbon\Carbon::now()->format('Y-m-d'));
    @endphp

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="mb-4 bg-green-600/30 border border-green-400 text-green-200 px-4 py-2 rounded">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 bg-red-600/30 border border-red-400 text-red-200 px-4 py-2 rounded">
            {{ session('error') }}
        </div>
    @endif

    {{-- Filter Tanggal --}}
    <form method="GET" action="{{ route('admin.scan.hadir') }}" class="mb-6">
        <div class="flex items-center space-x-2">
            <label for="tanggal" class="text-white text-sm">📅 Filter Tanggal:</label>
            <input type="date" name="tanggal" id="tanggal"
                   value="{{ $tanggalFix }}"
                   class="text-sm px-3 py-1 rounded border border-white/20 bg-white/10 text-white placeholder:text-white/40">
            <button type="submit"
                    class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-500 text-sm">
                🔍 Tampilkan
            </button>
            <a href="{{ route('admin.scan.hadir', ['tanggal' => \Carbon\Carbon::now()->format('Y-m-d')]) }}"
               class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-500 text-sm">
                ❌ Reset
            </a>
        </div>
    </form>

    @forelse ($groupedPaginated as $kelas => $pesertas)
        <div class="p-6 bg-white/5 text-white rounded shadow border border-white/10 backdrop-blur mb-8">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-white">👨‍🏫 Kelas {{ $kelas }}</h3>
                <a href="{{ route('admin.sertifikat.download', [
                    'id' => $jadwalIds[$kelas],
                    'kelas' => $kelas,
                    'tanggal' => $tanggalFix
                ]) }}"
                   class="text-sm bg-blue-700 px-3 py-1 rounded hover:bg-blue-600">⬇ Download PDF</a>
            </div>

            {{-- Search per kelas --}}
            <form method="GET" action="{{ route('admin.scan.hadir') }}" class="mb-4">
                <input type="hidden" name="tanggal" value="{{ $tanggalFix }}">
                <input type="hidden" name="kelas" value="{{ $kelas }}">
                <div class="flex space-x-2">
                    <input type="text" name="search_{{ $kelas }}" value="{{ request("search_$kelas") }}"
                           placeholder="Cari nama, nik..."
                           class="text-sm px-3 py-1 rounded bg-white/10 border border-white/20 text-white placeholder:text-white/40">
                    <button type="submit"
                            class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-500 text-sm">
                        🔍 Cari
                    </button>
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border border-white/20 text-sm">
                    <thead class="bg-white/10">
                        <tr>
                            <th class="px-4 py-2 border border-white/20 text-left">Nama</th>
                            <th class="px-4 py-2 border border-white/20 text-left">NIK</th>
                            <th class="px-4 py-2 border border-white/20 text-left">Judul Pelatihan</th>
                            <th class="px-4 py-2 border border-white/20 text-left">Tanggal Absen</th>
                            <th class="px-4 py-2 border border-white/20 text-left">Waktu Konfirmasi</th>
                            <th class="px-4 py-2 border border-white/20 text-left">Status</th>
                            <th class="px-4 py-2 border border-white/20 text-left">Setujui Sertifikat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pesertas as $row)
                            @php $biodata = $row->user->biodata; @endphp
                            <tr class="border-t border-white/10 hover:bg-white/5">
                                <td class="px-4 py-2 border border-white/10">{{ $biodata->nama ?? $row->user->name }}</td>
                                <td class="px-4 py-2 border border-white/10">{{ $biodata->nik ?? '-' }}</td>
                                <td class="px-4 py-2 border border-white/10">{{ $row->jadwalPelatihan->judul ?? '-' }}</td>
                                <td class="px-4 py-2 border border-white/10">{{ \Carbon\Carbon::parse($row->tanggal_absen)->format('d-m-Y') }}</td>
                                <td class="px-4 py-2 border border-white/10">{{ \Carbon\Carbon::parse($row->updated_at)->format('H:i') }} WIB</td>
                                <td class="px-4 py-2 border border-white/10">
                                    @if($biodata?->is_approved)
                                        <span class="px-2 py-1 bg-green-600 text-white rounded text-xs">Disetujui</span>
                                    @else
                                        <span class="px-2 py-1 bg-yellow-600 text-white rounded text-xs">Belum ACC</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 border border-white/10">
                                    @if(!$biodata?->is_approved)
                                        <form action="{{ route('admin.biodata.approve', $row->user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-xs px-3 py-1 bg-green-600 hover:bg-green-500 rounded text-white">
                                                ✅ Setujui
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.biodata.batal', $row->user->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="text-xs px-3 py-1 bg-red-600 hover:bg-red-500 rounded text-white">
                                                ❌ Batalkan
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $pesertas->appends(request()->query())->links() }}
            </div>
        </div>
    @empty
        <div class="p-6 bg-white/5 text-white rounded shadow border border-white/10 backdrop-blur">
            <p class="text-gray-300">Tidak ada data peserta ditemukan.</p>
        </div>
    @endforelse
</x-admin-layout>
