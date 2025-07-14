<x-admin-layout>
    <h2 class="text-xl font-semibold text-yellow-400 mb-4">📋 Daftar Biodata User</h2>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-600 text-white rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tombol Download Excel Biodata -->
    <div class="mb-4">
        <a href="{{ route('admin.biodata.excel') }}"
           class="inline-flex items-center gap-2 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-4 py-2 rounded-lg shadow text-sm transition duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 4v16h16V4H4zm8 8v4m0 0l-2-2m2 2l2-2m-2-8v4"/>
            </svg>
            <span>Download Excel Biodata Lengkap</span>
        </a>
    </div>

    <!-- Form Pencarian -->
    <form method="GET" action="{{ route('admin.user.biodata.index') }}" class="mb-4 flex items-center gap-2">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="🔍 Cari nama, NIK, atau jabatan..."
               class="px-3 py-2 w-64 rounded border border-gray-300 text-sm text-black focus:outline-none focus:ring focus:border-blue-300">

        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm shadow">
            Cari
        </button>

        @if(request('search'))
            <a href="{{ route('admin.user.biodata.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm shadow">
                🔄 Reset
            </a>
        @endif
    </form>

    <!-- Tabel -->
    <div class="bg-white/5 backdrop-blur rounded shadow border border-white/10 p-3 text-white inline-block w-auto max-w-full overflow-hidden">
        <div class="overflow-auto max-h-[70vh]">
            <table class="table-auto border-collapse text-xs w-full min-w-[1100px]">
                <thead class="bg-white/10 text-white/80 uppercase sticky top-0 z-10">
                    <tr>
                        <th class="px-2 py-2 text-left bg-gray-800">No</th>
                        <th class="px-2 py-2 text-left bg-gray-800">Nama</th>
                        <th class="px-2 py-2 text-left bg-gray-800">NIK</th>
                        <th class="px-2 py-2 text-left bg-gray-800">TTL</th>
                        <th class="px-2 py-2 text-left bg-gray-800">JK</th>
                        <th class="px-2 py-2 text-left bg-gray-800">Agama</th>
                        <th class="px-2 py-2 text-left bg-gray-800">Kawin</th>
                        <th class="px-2 py-2 text-left bg-gray-800">Jabatan</th>
                        <th class="px-2 py-2 text-left bg-gray-800">Lama</th>
                        <th class="px-2 py-2 text-left bg-gray-800">No SK</th>
                        <th class="px-2 py-2 text-left bg-gray-800">Pendidikan</th>
                        <th class="px-2 py-2 text-left bg-gray-800">Telepon</th>
                        <th class="px-2 py-2 text-center bg-gray-800">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @php
                        $page = request()->input('page', 1);
                        $perPage = $users->perPage();
                        $startNumber = ($page - 1) * $perPage + 1;
                    @endphp

                    @forelse($users as $user)
                        @if($user->biodata)
                            <tr class="hover:bg-white/10 transition">
                                <td class="px-2 py-1">{{ $startNumber + $loop->index }}</td>
                                <td class="px-2 py-1">{{ $user->name }}</td>
                                <td class="px-2 py-1">{{ $user->biodata->nik }}</td>
                                <td class="px-2 py-1">
                                    {{ $user->biodata->tempat_lahir }},
                                    {{ \Carbon\Carbon::parse($user->biodata->tanggal_lahir)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-2 py-1">{{ $user->biodata->jenis_kelamin }}</td>
                                <td class="px-2 py-1">{{ $user->biodata->agama }}</td>
                                <td class="px-2 py-1">{{ $user->biodata->status_kawin }}</td>
                                <td class="px-2 py-1">{{ $user->biodata->jabatan }}</td>
                                <td class="px-2 py-1">{{ $user->biodata->lama_menjabat }} th</td>
                                <td class="px-2 py-1">{{ $user->biodata->nomor_sk_jabatan }}</td>
                                <td class="px-2 py-1">{{ $user->biodata->pendidikan }}</td>
                                <td class="px-2 py-1">{{ $user->biodata->no_telp }}</td>
                                <td class="px-2 py-1 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('admin.user.biodata.edit', $user->id) }}"
                                           class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-xs">
                                            ✏️ Edit
                                        </a>
                                        <form action="{{ route('admin.user.biodata.destroy', $user->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus biodata ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-xs">
                                                🗑️ Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="13" class="text-center text-white/50 py-4 italic">Tidak ada data biodata.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $users->links('vendor.pagination.tailwind') }}
    </div>
</x-admin-layout>
