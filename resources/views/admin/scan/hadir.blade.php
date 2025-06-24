<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Daftar Kehadiran Peserta
        </h2>
    </x-slot>

    <div class="p-6 bg-white rounded shadow">
        @if($data->isEmpty())
            <p class="text-gray-500">Belum ada peserta yang hadir.</p>
        @else
            <table class="min-w-full table-auto border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">Nama</th>
                        <th class="px-4 py-2 border">NIK</th>
                        <th class="px-4 py-2 border">Judul Pelatihan</th>
                        <th class="px-4 py-2 border">Waktu Dikonfirmasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                        <tr class="border-t">
                            <td class="px-4 py-2 border">{{ $row->user->biodata->nama ?? $row->user->name }}</td>
                            <td class="px-4 py-2 border">{{ $row->user->biodata->nik ?? '-' }}</td>
                            <td class="px-4 py-2 border">{{ $row->jadwalPelatihan->judul ?? '-' }}</td>
                            <td class="px-4 py-2 border">
                                {{ \Carbon\Carbon::parse($row->updated_at)->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>
