<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Daftar Biodata User</h2>
    </x-slot>

    <div class="p-6 bg-white rounded shadow overflow-x-auto">
        <table class="min-w-full border text-sm">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border">Nama</th>
                    <th class="px-4 py-2 border">NIK</th>
                    <th class="px-4 py-2 border">Tempat, Tanggal Lahir</th>
                    <th class="px-4 py-2 border">Jenis Kelamin</th>
                    <th class="px-4 py-2 border">Agama</th>
                    <th class="px-4 py-2 border">Status Kawin</th>
                    <th class="px-4 py-2 border">Jabatan</th>
                    <th class="px-4 py-2 border">Lama Menjabat</th>
                    <th class="px-4 py-2 border">No SK Jabatan</th>
                    <th class="px-4 py-2 border">Pendidikan</th>
                    <th class="px-4 py-2 border">No Telepon</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    @if($user->biodata)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $user->name }}</td>
                            <td class="px-4 py-2 border">{{ $user->biodata->nik }}</td>
                            <td class="px-4 py-2 border">{{ $user->biodata->tempat_lahir }}, {{ $user->biodata->tanggal_lahir }}</td>
                            <td class="px-4 py-2 border">{{ $user->biodata->jenis_kelamin }}</td>
                            <td class="px-4 py-2 border">{{ $user->biodata->agama }}</td>
                            <td class="px-4 py-2 border">{{ $user->biodata->status_kawin }}</td>
                            <td class="px-4 py-2 border">{{ $user->biodata->jabatan }}</td>
                            <td class="px-4 py-2 border">{{ $user->biodata->lama_menjabat }} tahun</td>
                            <td class="px-4 py-2 border">{{ $user->biodata->nomor_sk_jabatan }}</td>
                            <td class="px-4 py-2 border">{{ $user->biodata->pendidikan }}</td>
                            <td class="px-4 py-2 border">{{ $user->biodata->no_telp }}</td>
                            <td class="px-4 py-2 border text-center">
                                <a href="{{ route('admin.user.biodata.edit', $user->id) }}" class="text-blue-600 hover:underline text-xs">✏️ Edit</a>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
