<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Jadwal Pelatihan</h2>
    </x-slot>

    <div class="p-6 bg-white rounded shadow space-y-4">
        {{-- Tombol tambah jadwal --}}
        <a href="{{ route('admin.jadwal-pelatihan.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Tambah Jadwal</a>

        {{-- Notifikasi sukses --}}
        @if(session('success'))
            <div class="text-green-600">{{ session('success') }}</div>
        @endif

        {{-- Tabel jadwal --}}
        <table class="min-w-full border divide-y">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">Judul</th>
                    <th class="px-4 py-2">Tanggal</th>
                    <th class="px-4 py-2">Pembiayaan</th>
                    <th class="px-4 py-2">Kelas</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jadwals as $jadwal)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $jadwal->judul }}</td>
                    <td class="px-4 py-2">{{ $jadwal->tgl_mulai }} s/d {{ $jadwal->tgl_selesai }}</td>
                    <td class="px-4 py-2">{{ $jadwal->pembiayaan }}</td>
                    <td class="px-4 py-2">{{ $jadwal->kelas }}</td>
                    <td class="px-4 py-2">
                        @if($jadwal->status)
                            <span class="text-green-600 font-bold">Aktif</span>
                        @else
                            <span class="text-gray-600">Tidak Aktif</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 space-x-2">
                        {{-- Tombol Edit --}}
                        <a href="{{ route('admin.jadwal-pelatihan.edit', $jadwal->id) }}" class="text-blue-600 hover:underline">Edit</a>

                        {{-- Tombol Hapus --}}
                        <form action="{{ route('admin.jadwal-pelatihan.destroy', $jadwal->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Hapus</button>
                        </form>

                        {{-- ✅ Tombol Lihat Pendaftar --}}
                        <a href="{{ route('admin.jadwal-pelatihan.show', $jadwal->id) }}" class="text-blue-600 hover:underline">
                            Lihat Peserta
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
