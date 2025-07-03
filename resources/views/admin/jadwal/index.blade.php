<x-admin-layout>
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold text-white">📅 Jadwal Pelatihan</h2>
        <a href="{{ route('admin.jadwal-pelatihan.create') }}"
           class="bg-yellow-400 text-blue-900 px-4 py-2 rounded hover:bg-yellow-300 font-semibold shadow">
            + Tambah Jadwal
        </a>
    </div>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="text-green-300 bg-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabel --}}
    <div class="bg-white/5 p-6 rounded-lg shadow border border-white/10 backdrop-blur text-white">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-white/10">
                <thead class="bg-white/10">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Judul</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Tanggal</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Provinsi</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Kabupaten</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Pembiayaan</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Kelas</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Status</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse($jadwals as $jadwal)
                        <tr>
                            <td class="px-4 py-2 text-sm">{{ $jadwal->judul }}</td>
                            <td class="px-4 py-2 text-sm">{{ $jadwal->tgl_mulai }} s/d {{ $jadwal->tgl_selesai }}</td>
                            <td class="px-4 py-2 text-sm">{{ $jadwal->provinsi->nama ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm">{{ $jadwal->kabupatenkota->nama ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm">{{ $jadwal->pembiayaan }}</td>
                            <td class="px-4 py-2 text-sm">{{ $jadwal->kelas }}</td>
                            <td class="px-4 py-2 text-sm">
                                @if($jadwal->status)
                                    <span class="inline-block bg-green-600 text-white text-xs px-2 py-1 rounded">Aktif</span>
                                @else
                                    <span class="inline-block bg-gray-500 text-white text-xs px-2 py-1 rounded">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-sm space-x-2">
                                <a href="{{ route('admin.jadwal-pelatihan.edit', $jadwal->id) }}"
                                   class="px-3 py-1 bg-yellow-300 text-xs rounded hover:bg-yellow-400 text-blue-900">✏️ Edit</a>

                                <form action="{{ route('admin.jadwal-pelatihan.destroy', $jadwal->id) }}"
                                      method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf @method('DELETE')
                                    <button class="px-3 py-1 bg-red-500 text-xs rounded hover:bg-red-600">🗑️ Hapus</button>
                                </form>

                                <a href="{{ route('admin.jadwal-pelatihan.show', $jadwal->id) }}"
                                   class="px-3 py-1 bg-blue-500 text-xs rounded hover:bg-blue-600 text-white">👥 Peserta</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-4 text-center text-sm text-white/70">Belum ada data jadwal pelatihan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
