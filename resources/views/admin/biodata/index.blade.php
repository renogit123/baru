<x-admin-layout>
    <h2 class="text-2xl font-semibold text-yellow-400 mb-6">Daftar Biodata User</h2>

    <!-- Tombol Export PDF -->
    <div class="mb-6">
        <a href="{{ route('admin.nilai.kosong') }}"
           class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow transition">
            📄 Download PDF Nilai PRE TEST dan POST TEST
        </a>
    </div>

    <!-- Tabel -->
    <div class="bg-gradient-to-br from-[#0a1f44] to-[#1e40af] rounded shadow-lg text-white p-6 w-full max-w-7xl mx-auto">
        <div class="overflow-x-auto bg-white/5 backdrop-blur border border-white/10 rounded-lg">
            <table class="w-full table-auto divide-y divide-white/10 text-sm md:text-base">
                <thead class="bg-white/10 text-left font-semibold uppercase text-white/80">
                    <tr>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">NIK</th>
                        <th class="px-4 py-3">Tempat, Tanggal Lahir</th>
                        <th class="px-4 py-3">Jenis Kelamin</th>
                        <th class="px-4 py-3">Agama</th>
                        <th class="px-4 py-3">Status Kawin</th>
                        <th class="px-4 py-3">Jabatan</th>
                        <th class="px-4 py-3">Lama Menjabat</th>
                        <th class="px-4 py-3">No SK Jabatan</th>
                        <th class="px-4 py-3">Pendidikan</th>
                        <th class="px-4 py-3">No Telepon</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse($users as $user)
                        @if($user->biodata)
                            <tr class="hover:bg-white/10 transition">
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
                                <td class="px-4 py-2">
                                    <div class="flex flex-col items-start space-y-1 text-xs">
                                        <a href="{{ route('admin.user.biodata.edit', $user->id) }}"
                                           class="text-yellow-300 hover:underline transition">
                                            ✏️ Edit
                                        </a>
                                        <form action="{{ route('admin.user.biodata.destroy', $user->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus biodata ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:underline transition">
                                                🗑️ Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="12" class="px-4 py-6 text-center text-white/70 italic">
                                Tidak ada data biodata.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
