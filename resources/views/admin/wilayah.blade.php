<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Manajemen Wilayah</h2>
    </x-slot>

    <div class="p-6 space-y-10">
        {{-- ========== FORM ========== --}}
        @foreach ([
            ['title' => 'Provinsi', 'fields' => ['nama' => 'Nama Provinsi', 'kode' => 'Kode Provinsi'], 'action' => 'provinsi', 'editVar' => 'editProvinsi', 'related' => []],
            ['title' => 'Kabupaten / Kota', 'fields' => ['provinsi_id' => 'Pilih Provinsi', 'nama' => 'Nama Kabupaten/Kota', 'kode' => 'Kode'], 'action' => 'kabupaten-kota', 'editVar' => 'editKabupaten', 'related' => $provinsis],
            ['title' => 'Kecamatan', 'fields' => ['kabupaten_kota_id' => 'Pilih Kabupaten/Kota', 'nama' => 'Nama Kecamatan', 'kode' => 'Kode'], 'action' => 'kecamatan', 'editVar' => 'editKecamatan', 'related' => $kabupatens],
            ['title' => 'Kelurahan / Desa', 'fields' => ['kecamatan_id' => 'Pilih Kecamatan', 'nama' => 'Nama Kelurahan/Desa', 'kode' => 'Kode'], 'action' => 'kelurahan', 'editVar' => 'editKelurahan', 'related' => $kecamatans],
        ] as $section)
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-4">{{ $section['title'] }}</h3>
            <form method="POST" action="{{ isset(${$section['editVar']}) ? route('admin.' . $section['action'] . '.update', ${$section['editVar']}->id) : route('admin.' . $section['action'] . '.store') }}" class="space-y-4">
                @csrf
                @if(isset(${$section['editVar']}))
                    @method('PUT')
                @endif

                <div class="grid md:grid-cols-2 gap-4">
                    @foreach ($section['fields'] as $name => $label)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">{{ $label }}</label>
                            @if(Str::endsWith($name, '_id'))
                                <select name="{{ $name }}" class="mt-1 block w-full border border-gray-300 rounded-md">
                                    <option value="">-- {{ $label }} --</option>
                                    @foreach ($section['related'] as $rel)
                                        <option value="{{ $rel->id }}" {{ old($name, ${$section['editVar']}->$name ?? '') == $rel->id ? 'selected' : '' }}>
                                            {{ $rel->nama ?? '-' }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <input type="text" name="{{ $name }}" value="{{ old($name, ${$section['editVar']}->$name ?? '') }}" class="mt-1 block w-full border border-gray-300 rounded-md">
                            @endif
                        </div>
                    @endforeach
                </div>

                <div>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        {{ isset(${$section['editVar']}) ? 'Update' : 'Tambah' }}
                    </button>
                    @if(isset(${$section['editVar']}))
                        <a href="{{ route('admin.wilayah') }}" class="ml-4 text-sm text-gray-600 hover:underline">Batal</a>
                    @endif
                </div>
            </form>
        </div>
        @endforeach

        {{-- ========== TABEL ========== --}}
        @foreach ([
            ['title' => 'Daftar Provinsi', 'items' => $provinsis, 'cols' => ['nama', 'kode'], 'action' => 'provinsi'],
            ['title' => 'Daftar Kabupaten/Kota', 'items' => $kabupatens, 'cols' => ['nama', 'kode', 'provinsi.nama'], 'action' => 'kabupaten-kota'],
            ['title' => 'Daftar Kecamatan', 'items' => $kecamatans, 'cols' => ['nama', 'kode', 'kabupatenKota.nama'], 'action' => 'kecamatan'],
            ['title' => 'Daftar Kelurahan/Desa', 'items' => $kelurahans, 'cols' => ['nama', 'kode', 'kecamatan.nama'], 'action' => 'kelurahan'],
        ] as $table)
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-4">{{ $table['title'] }}</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full border divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            @foreach($table['cols'] as $col)
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">
                                    {{ ucwords(str_replace(['.', '_'], ' ', $col)) }}
                                </th>
                            @endforeach
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($table['items'] as $item)
                            <tr class="hover:bg-gray-50">
                                @foreach($table['cols'] as $col)
                                    <td class="px-6 py-4 text-sm text-gray-800">
                                        {{ data_get($item, $col) }}
                                    </td>
                                @endforeach
                                <td class="px-6 py-4 text-sm text-gray-800 space-x-2">
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('admin.wilayah', ['edit_' . Str::slug($table['action'], '_') => $item->id]) }}"
                                        class="inline-flex items-center px-3 py-1 bg-yellow-300 text-black text-xs font-medium rounded hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-300">
                                        ✏️ Edit
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    <form method="POST"
                                          action="{{ route('admin.' . $table['action'] . '.destroy', $item->id) }}"
                                          class="inline-block"
                                          onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-1 bg-red-300 text-black text-xs font-medium rounded hover:bg-red-400 focus:outline-none focus:ring-2 focus:ring-red-300">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
    </div>
</x-app-layout>
