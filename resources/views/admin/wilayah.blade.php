<x-admin-layout>
    <h2 class="text-xl font-semibold text-white">Lihat Semua Wilayah</h2>

    <div class="p-6 space-y-10 bg-gradient-to-br from-[#0a1f44] to-[#1e40af] min-h-screen text-white">
        @foreach ([
            ['title' => 'Daftar Wilayah (Kelurahan / Desa)', 'items' => $kelurahans, 'cols' => [
                'nama' => 'Nama',
                'kode' => 'Kode',
                'kecamatan.nama' => 'Kecamatan',
                'kecamatan.kabupatenKota.nama' => 'Kabupaten/Kota',
                'kecamatan.kabupatenKota.provinsi.nama' => 'Provinsi'
            ], 'action' => 'kelurahan', 'editVar' => 'edit_kelurahan', 'searchKey' => 'search_kelurahan'],
        ] as $table)
            <div
                x-data="{
                    show: JSON.parse(localStorage.getItem('{{ $table['editVar'] }}_show') ?? 'true'),
                    toggle() {
                        this.show = !this.show;
                        localStorage.setItem('{{ $table['editVar'] }}_show', JSON.stringify(this.show));
                    }
                }"
                class="bg-white/5 p-6 rounded-lg shadow border border-white/10 backdrop-blur"
            >
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">{{ $table['title'] }}</h3>
                    <button @click="toggle" class="text-sm px-3 py-1 bg-white/10 hover:bg-white/20 rounded">
                        <span x-show="!show">📂 Tampilkan</span>
                        <span x-show="show">📁 Sembunyikan</span>
                    </button>
                </div>

                <div x-show="show" x-transition>
                    <form method="GET" class="mb-4">
                        <input type="text" name="{{ $table['searchKey'] }}" value="{{ request($table['searchKey']) }}" placeholder="Cari..." class="border px-3 py-1 rounded w-64 text-black">
                        <button type="submit" class="ml-2 px-3 py-1 bg-gray-100 hover:bg-gray-200 text-sm rounded text-black">🔍 Cari</button>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border divide-y divide-white/10">
                            <thead class="bg-white/10">
                                <tr>
                                    @foreach($table['cols'] as $col => $label)
                                        <th class="px-4 py-2 text-left text-sm font-semibold text-white">{{ $label }}</th>
                                    @endforeach
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-white">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/10">
                                @foreach($table['items'] as $item)
                                    <tr>
                                        @foreach($table['cols'] as $col => $label)
                                            <td class="px-4 py-2 text-sm text-white/90">{{ data_get($item, $col) }}</td>
                                        @endforeach
                                        <td class="px-4 py-2 text-sm space-x-2">
                                            <a href="{{ route('admin.wilayah', [$table['editVar'] => $item->id]) }}" class="px-3 py-1 bg-yellow-300 text-xs rounded hover:bg-yellow-400 text-blue-900">✏️ Edit</a>
                                            <form method="POST" action="{{ route('admin.' . $table['action'] . '.destroy', $item->id) }}" class="inline-block" onsubmit="return confirm('Hapus data ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="px-3 py-1 bg-red-500 text-xs rounded hover:bg-red-600">🗑️ Hapus</button>
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
</x-admin-layout>
