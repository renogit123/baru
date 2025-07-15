<x-admin-layout>
    <h2 class="text-xl font-semibold text-white">Manajemen Wilayah</h2>

    <div class="p-6 space-y-10 bg-gradient-to-br from-[#0a1f44] to-[#1e40af] min-h-screen text-white">
        {{-- ========== FORM TAMBAH / EDIT ========== --}}
        @foreach ([
            ['title' => 'Provinsi', 'fields' => ['nama' => 'Nama Provinsi', 'kode' => 'Kode Provinsi'], 'action' => 'provinsi', 'editVar' => 'editProvinsi', 'related' => []],
        ] as $section)
            @php $editItem = ${$section['editVar']} ?? null; @endphp
            <div class="bg-white/5 p-6 rounded-lg shadow border border-white/10 backdrop-blur">
                <h3 class="text-lg font-semibold mb-4 text-white">{{ $section['title'] }}</h3>
                <form method="POST" action="{{ isset($editItem) ? route('admin.' . $section['action'] . '.update', $editItem->id) : route('admin.' . $section['action'] . '.store') }}">
                    @csrf
                    @if(isset($editItem)) @method('PUT') @endif
                    <div class="grid md:grid-cols-2 gap-4">
                        @foreach ($section['fields'] as $name => $label)
                            <div>
                                <label class="block text-sm font-medium text-white/90">{{ $label }}</label>
                                @if(Str::endsWith($name, '_id'))
                                    <select name="{{ $name }}" class="mt-1 block w-full border border-gray-300 rounded-md text-black">
                                        <option value="">-- {{ $label }} --</option>
                                        @foreach ($section['related'] as $rel)
                                            <option value="{{ $rel->id }}" {{ old($name, $editItem->$name ?? '') == $rel->id ? 'selected' : '' }}>
                                                {{ $rel->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="text" name="{{ $name }}" value="{{ old($name, $editItem->$name ?? '') }}" class="mt-1 block w-full border border-gray-300 rounded-md text-black">
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <button class="bg-yellow-400 text-blue-900 px-4 py-2 rounded hover:bg-yellow-300">
                            {{ isset($editItem) ? 'Update' : 'Tambah' }}
                        </button>
                        @if(isset($editItem))
                            <a href="{{ route('admin.wilayah') }}" class="ml-3 text-sm text-white/70 hover:underline">Batal</a>
                        @endif
                    </div>
                </form>
            </div>
        @endforeach

        {{-- ========== TABEL DATA ========== --}}
        @foreach ([
            ['title' => 'Daftar Provinsi', 'items' => $provinsis, 'cols' => ['nama' => 'Nama', 'kode' => 'Kode'], 'action' => 'provinsi', 'editVar' => 'edit_provinsi', 'searchKey' => 'search_provinsi'],
        ] as $table)
            <div
                x-data="{
                    show: JSON.parse(localStorage.getItem('{{ $table['editVar'] }}_show') ?? 'false'),
                    toggle() {
                        this.show = !this.show;
                        localStorage.setItem('{{ $table['editVar'] }}_show', JSON.stringify(this.show));
                    }
                }"
                class="bg-white/5 p-6 rounded-lg shadow border border-white/10 backdrop-blur"
            >
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-white">{{ $table['title'] }}</h3>
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
                                            <a href="{{ route('admin.provinsi.index', ['editProvinsi' => $item->id]) }}" class="px-3 py-1 bg-yellow-300 text-xs rounded hover:bg-yellow-400 text-blue-900">✏ Edit</a>
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
