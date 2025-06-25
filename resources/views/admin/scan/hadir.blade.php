<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-white">
                📝 Daftar Kehadiran Peserta
            </h2>
            <a href="{{ route('admin.jadwal-pelatihan.index') }}"
               class="text-sm text-white/70 hover:underline">⬅️ Kembali</a>
        </div>
    </x-slot>

    <div class="p-6 bg-white/5 text-white rounded shadow border border-white/10 backdrop-blur">
        @if($data->isEmpty())
            <p class="text-gray-300">Belum ada peserta yang hadir.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border border-white/20 text-sm">
                    <thead class="bg-white/10">
                        <tr>
                            <th class="px-4 py-2 border border-white/20 text-left">Nama</th>
                            <th class="px-4 py-2 border border-white/20 text-left">NIK</th>
                            <th class="px-4 py-2 border border-white/20 text-left">Judul Pelatihan</th>
                            <th class="px-4 py-2 border border-white/20 text-left">Waktu Dikonfirmasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                            <tr class="border-t border-white/10 hover:bg-white/5">
                                <td class="px-4 py-2 border border-white/10">{{ $row->user->biodata->nama ?? $row->user->name }}</td>
                                <td class="px-4 py-2 border border-white/10">{{ $row->user->biodata->nik ?? '-' }}</td>
                                <td class="px-4 py-2 border border-white/10">{{ $row->jadwalPelatihan->judul ?? '-' }}</td>
                                <td class="px-4 py-2 border border-white/10">
                                    {{ \Carbon\Carbon::parse($row->updated_at)->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-admin-layout>
