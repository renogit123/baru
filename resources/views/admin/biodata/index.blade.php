<x-admin-layout>
    <h2 class="text-xl font-semibold text-white mb-4">Daftar Biodata User</h2>

        <!-- Tombol Export PDF -->
        <div class="mb-4">
            <a href="{{ route('admin.nilai.kosong') }}"
               class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
                📄 Download PDF Nilai PRE TEST dan POST TEST
            </a>
        </div>

    <div class="p-6 bg-gradient-to-br from-[#0a1f44] to-[#1e40af] rounded shadow min-h-screen text-white">
        <div class="overflow-x-auto bg-white/5 backdrop-blur border border-white/10 rounded-lg p-4">
            <table class="min-w-full border divide-y divide-white/10 text-sm">
                <thead class="bg-white/10">
                    <tr>
                        <th class="px-4 py-2 text-left font-semibold">Nama</th>
                        <th class="px-4 py-2 text-left font-semibold">NIK</th>
                        <th class="px-4 py-2 text-left font-semibold">Tempat, Tanggal Lahir</th>
                        <th class="px-4 py-2 text-left font-semibold">Jenis Kelamin</th>
                        <th class="px-4 py-2 text-left font-semibold">Agama</th>
                        <th class="px-4 py-2 text-left font-semibold">Status Kawin</th>
                        <th class="px-4 py-2 text-left font-semibold">Jabatan</th>
                        <th class="px-4 py-2 text-left font-semibold">Lama Menjabat</th>
                        <th class="px-4 py-2 text-left font-semibold">No SK Jabatan</th>
                        <th class="px-4 py-2 text-left font-semibold">Pendidikan</th>
                        <th class="px-4 py-2 text-left font-semibold">No Telepon</th>
                        <th class="px-4 py-2 text-left font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse($users as $user)
                        @if($user->biodata)
                            <tr class="hover:bg-white/5">
                                <td class="px-4 py-2">{{ $user->name }}</td>
                                <td class="px-4 py-2">{{ $user->biodata->nik }}</td>
                                <td class="px-4 py-2">{{ $user->biodata->tempat_lahir }}, {{ $user->biodata->tanggal_lahir }}</td>
                                <td class="px-4 py-2">{{ $user->biodata->jenis_kelamin }}</td>
                                <td class="px-4 py-2">{{ $user->biodata->agama }}</td>
                                <td class="px-4 py-2">{{ $user->biodata->status_kawin }}</td>
                                <td class="px-4 py-2">{{ $user->biodata->jabatan }}</td>
                                <td class="px-4 py-2">{{ $user->biodata->lama_menjabat }} tahun</td>
                                <td class="px-4 py-2">{{ $user->biodata->nomor_sk_jabatan }}</td>
                                <td class="px-4 py-2">{{ $user->biodata->pendidikan }}</td>
                                <td class="px-4 py-2">{{ $user->biodata->no_telp }}</td>
                                <td class="px-4 py-2 space-y-1">
                                    <a href="{{ route('admin.user.biodata.edit', $user->id) }}"
                                       class="text-yellow-300 hover:underline text-xs block">
                                        ✏️ Edit
                                    </a>

                                    <form action="{{ route('admin.user.biodata.destroy', $user->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus biodata ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:underline text-xs">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="12" class="px-4 py-2 text-center text-white/70">Tidak ada data biodata.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
