<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Manajemen Wilayah</h2>
    </x-slot>

    <div class="p-6 space-y-10">
        {{-- ========== FORM TAMBAH / EDIT ========== --}}
        @foreach ([
            ['title' => 'Provinsi', 'fields' => ['nama' => 'Nama Provinsi', 'kode' => 'Kode Provinsi'], 'action' => 'provinsi', 'editVar' => 'editProvinsi', 'related' => []],
            ['title' => 'Kabupaten / Kota', 'fields' => ['provinsi_id' => 'Pilih Provinsi', 'nama' => 'Nama Kabupaten/Kota', 'kode' => 'Kode'], 'action' => 'kabupaten-kota', 'editVar' => 'editKabupaten', 'related' => $provinsis],
            ['title' => 'Kecamatan', 'fields' => ['kabupaten_kota_id' => 'Pilih Kabupaten/Kota', 'nama' => 'Nama Kecamatan', 'kode' => 'Kode'], 'action' => 'kecamatan', 'editVar' => 'editKecamatan', 'related' => $kabupatens],
            ['title' => 'Kelurahan / Desa', 'fields' => ['kecamatan_id' => 'Pilih Kecamatan', 'nama' => 'Nama Kelurahan/Desa', 'kode' => 'Kode'], 'action' => 'kelurahan', 'editVar' => 'editKelurahan', 'related' => $kecamatans],
        ] as $section)
            @php $editItem = ${$section['editVar']} ?? null; @endphp
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-4">{{ $section['title'] }}</h3>
                <form method="POST" action="{{ isset($editItem) ? route('admin.' . $section['action'] . '.update', $editItem->id) : route('admin.' . $section['action'] . '.store') }}">
                    @csrf
                    @if(isset($editItem)) @method('PUT') @endif
                    <div class="grid md:grid-cols-2 gap-4">
                        @foreach ($section['fields'] as $name => $label)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">{{ $label }}</label>
                                @if(Str::endsWith($name, '_id'))
                                    <select name="{{ $name }}" class="mt-1 block w-full border border-gray-300 rounded-md">
                                        <option value="">-- {{ $label }} --</option>
                                        @foreach ($section['related'] as $rel)
                                            <option value="{{ $rel->id }}" {{ old($name, $editItem->$name ?? '') == $rel->id ? 'selected' : '' }}>
                                                {{ $rel->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="text" name="{{ $name }}" value="{{ old($name, $editItem->$name ?? '') }}" class="mt-1 block w-full border border-gray-300 rounded-md">
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            {{ isset($editItem) ? 'Update' : 'Tambah' }}
                        </button>
                        @if(isset($editItem))
                            <a href="{{ route('admin.wilayah') }}" class="ml-3 text-sm text-gray-600 hover:underline">Batal</a>
                        @endif
                    </div>
                </form>
            </div>
        @endforeach

        {{-- ========== TABEL DATA ========== --}}
        @foreach ([
            ['title' => 'Daftar Provinsi', 'items' => $provinsis, 'cols' => ['nama' => 'Nama', 'kode' => 'Kode'], 'action' => 'provinsi', 'editVar' => 'edit_provinsi', 'searchKey' => 'search_provinsi'],
            ['title' => 'Daftar Kabupaten/Kota', 'items' => $kabupatens, 'cols' => ['nama' => 'Nama', 'kode' => 'Kode', 'provinsi.nama' => 'Provinsi'], 'action' => 'kabupaten-kota', 'editVar' => 'edit_kabupaten_kota', 'searchKey' => 'search_kabupaten_kota'],
            ['title' => 'Daftar Kecamatan', 'items' => $kecamatans, 'cols' => ['nama' => 'Nama', 'kode' => 'Kode', 'kabupatenKota.nama' => 'Kabupaten/Kota'], 'action' => 'kecamatan', 'editVar' => 'edit_kecamatan', 'searchKey' => 'search_kecamatan'],
            ['title' => 'Daftar Kelurahan/Desa', 'items' => $kelurahans, 'cols' => [
                'nama' => 'Nama',
                'kode' => 'Kode',
                'kecamatan.nama' => 'Kecamatan',
                'kecamatan.kabupatenKota.nama' => 'Kabupaten/Kota',
                'kecamatan.kabupatenKota.provinsi.nama' => 'Provinsi'
            ], 'action' => 'kelurahan', 'editVar' => 'edit_kelurahan', 'searchKey' => 'search_kelurahan'],
        ] as $table)
            <div
                x-data="{
                    show: JSON.parse(localStorage.getItem('{{ $table['editVar'] }}_show') ?? 'false'),
                    toggle() {
                        this.show = !this.show;
                        localStorage.setItem('{{ $table['editVar'] }}_show', JSON.stringify(this.show));
                    }
                }"
                class="bg-white p-6 rounded-lg shadow"
            >
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">{{ $table['title'] }}</h3>
                    <button @click="toggle" class="text-sm px-3 py-1 bg-indigo-100 hover:bg-indigo-200 rounded">
                        <span x-show="!show">📂 Tampilkan</span>
                        <span x-show="show">📁 Sembunyikan</span>
                    </button>
                </div>

                <div x-show="show" x-transition>
                    <form method="GET" class="mb-4">
                        <input type="text" name="{{ $table['searchKey'] }}" value="{{ request($table['searchKey']) }}" placeholder="Cari..." class="border px-3 py-1 rounded w-64">
                        <button type="submit" class="ml-2 px-3 py-1 bg-gray-100 hover:bg-gray-200 text-sm rounded">🔍 Cari</button>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    @foreach($table['cols'] as $col => $label)
                                        <th class="px-4 py-2 text-left text-sm font-semibold">{{ $label }}</th>
                                    @endforeach
                                    <th class="px-4 py-2 text-left text-sm font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($table['items'] as $item)
                                    <tr>
                                        @foreach($table['cols'] as $col => $label)
                                            <td class="px-4 py-2 text-sm text-gray-700">{{ data_get($item, $col) }}</td>
                                        @endforeach
                                        <td class="px-4 py-2 text-sm space-x-2">
                                            <a href="{{ route('admin.wilayah', [$table['editVar'] => $item->id]) }}" class="px-3 py-1 bg-yellow-300 text-xs rounded hover:bg-yellow-400">✏️ Edit</a>
                                            <form method="POST" action="{{ route('admin.' . $table['action'] . '.destroy', $item->id) }}" class="inline-block" onsubmit="return confirm('Hapus data ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="px-3 py-1 bg-red-300 text-xs rounded hover:bg-red-400">🗑️ Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $table['items']->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
