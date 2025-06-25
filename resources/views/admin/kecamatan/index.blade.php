<x-admin-layout>
    <h2 class="text-xl font-semibold text-white">Manajemen Wilayah - Kecamatan</h2>

    <div class="p-6 space-y-10 bg-gradient-to-br from-[#0a1f44] to-[#1e40af] min-h-screen text-white">
        {{-- ========== FORM TAMBAH / EDIT ========== --}}
        @php $editItem = $editKecamatan ?? null; @endphp
        <div class="bg-white/5 p-6 rounded-lg shadow border border-white/10 backdrop-blur">
            <h3 class="text-lg font-semibold mb-4 text-white">Kecamatan</h3>
            <form method="POST" action="{{ isset($editItem) ? route('admin.kecamatan.update', $editItem->id) : route('admin.kecamatan.store') }}">
                @csrf
                @if(isset($editItem)) @method('PUT') @endif
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-white/90">Pilih Kabupaten/Kota</label>
                        <select name="kabupaten_kota_id" class="mt-1 block w-full border border-gray-300 rounded-md text-black">
                            <option value="">-- Pilih Kabupaten/Kota --</option>
                            @foreach ($kabupatens as $kk)
                                <option value="{{ $kk->id }}" {{ old('kabupaten_kota_id', $editItem->kabupaten_kota_id ?? '') == $kk->id ? 'selected' : '' }}>
                                    {{ $kk->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-white/90">Nama Kecamatan</label>
                        <input type="text" name="nama" value="{{ old('nama', $editItem->nama ?? '') }}" class="mt-1 block w-full border border-gray-300 rounded-md text-black">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-white/90">Kode</label>
                        <input type="text" name="kode" value="{{ old('kode', $editItem->kode ?? '') }}" class="mt-1 block w-full border border-gray-300 rounded-md text-black">
                    </div>
                </div>
                <div class="mt-4">
                    <button class="bg-yellow-400 text-blue-900 px-4 py-2 rounded hover:bg-yellow-300">
                        {{ isset($editItem) ? 'Update' : 'Tambah' }}
                    </button>
                    @if(isset($editItem))
                        <a href="{{ route('admin.kecamatan.index') }}" class="ml-3 text-sm text-white/70 hover:underline">Batal</a>
                    @endif
                </div>
            </form>
        </div>

        {{-- ========== TABEL DATA ========== --}}
        <div
            x-data="{
                show: JSON.parse(localStorage.getItem('edit_kecamatan_show') ?? 'false'),
                toggle() {
                    this.show = !this.show;
                    localStorage.setItem('edit_kecamatan_show', JSON.stringify(this.show));
                }
            }"
            class="bg-white/5 p-6 rounded-lg shadow border border-white/10 backdrop-blur"
        >
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-white">Daftar Kecamatan</h3>
                <button @click="toggle" class="text-sm px-3 py-1 bg-white/10 hover:bg-white/20 rounded">
                    <span x-show="!show">📂 Tampilkan</span>
                    <span x-show="show">📁 Sembunyikan</span>
                </button>
            </div>

            <div x-show="show" x-transition>
                <form method="GET" class="mb-4">
                    <input type="text" name="search_kecamatan" value="{{ request('search_kecamatan') }}" placeholder="Cari..." class="border px-3 py-1 rounded w-64 text-black">
                    <button type="submit" class="ml-2 px-3 py-1 bg-gray-100 hover:bg-gray-200 text-sm rounded text-black">🔍 Cari</button>
                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-full border divide-y divide-white/10">
                        <thead class="bg-white/10">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-white">Nama</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-white">Kode</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-white">Kabupaten/Kota</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-white">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @foreach($kecamatans as $item)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-white/90">{{ $item->nama }}</td>
                                    <td class="px-4 py-2 text-sm text-white/90">{{ $item->kode }}</td>
                                    <td class="px-4 py-2 text-sm text-white/90">{{ $item->kabupatenKota->nama ?? '-' }}</td>
                                    <td class="px-4 py-2 text-sm space-x-2">
                                        <a href="{{ route('admin.kecamatan.index', ['edit_kecamatan' => $item->id]) }}" class="px-3 py-1 bg-yellow-300 text-xs rounded hover:bg-yellow-400 text-blue-900">✏️ Edit</a>
                                        <form method="POST" action="{{ route('admin.kecamatan.destroy', $item->id) }}" class="inline-block" onsubmit="return confirm('Hapus data ini?')">
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
                    {{ $kecamatans->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
