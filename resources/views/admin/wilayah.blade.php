<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Wilayah</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">

    {{-- NAVIGASI SINGKAT --}}
    <div class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-xl font-bold">Dashboard Admin - Wilayah</h1>
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">Kembali ke Dashboard</a>
    </div>

    <div class="p-6 space-y-10 max-w-screen-xl mx-auto">

        {{-- === FORM INPUT === --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Provinsi --}}
            <div class="bg-white p-4 rounded-xl shadow">
                <h2 class="text-lg font-semibold mb-3">Tambah Provinsi</h2>
                <form method="POST" action="{{ route('admin.provinsi.store') }}" class="space-y-2">
                    @csrf
                    <input name="nama" placeholder="Nama Provinsi" class="w-full form-input rounded border-gray-300">
                    <input name="kode" placeholder="Kode" class="w-full form-input rounded border-gray-300">
                    <button type="submit" class="w-full bg-blue-600 text-black py-2 rounded hover:bg-blue-700">Tambah</button>
                </form>
            </div>

            {{-- Kabupaten/Kota --}}
            <div class="bg-white p-4 rounded-xl shadow">
                <h2 class="text-lg font-semibold mb-3">Tambah Kabupaten/Kota</h2>
                <form method="POST" action="{{ route('admin.kabupaten-kota.store') }}" class="space-y-2">
                    @csrf
                    <select name="provinsi_id" class="w-full form-select rounded border-gray-300">
                        <option value="">-- Pilih Provinsi --</option>
                        @foreach ($provinsis as $prov)
                            <option value="{{ $prov->id }}">{{ $prov->nama }}</option>
                        @endforeach
                    </select>
                    <input name="nama" placeholder="Nama Kabupaten/Kota" class="w-full form-input rounded border-gray-300">
                    <input name="kode" placeholder="Kode" class="w-full form-input rounded border-gray-300">
                    <button type="submit" class="w-full bg-blue-600 text-black py-2 rounded hover:bg-blue-700">Tambah</button>
                </form>
            </div>

            {{-- Kecamatan --}}
            <div class="bg-white p-4 rounded-xl shadow">
                <h2 class="text-lg font-semibold mb-3">Tambah Kecamatan</h2>
                <form method="POST" action="{{ route('admin.kecamatan.store') }}" class="space-y-2">
                    @csrf
                    <select name="kabupaten_kota_id" class="w-full form-select rounded border-gray-300">
                        <option value="">-- Pilih Kab/Kota --</option>
                        @foreach ($kabupatens as $kab)
                            <option value="{{ $kab->id }}">{{ $kab->nama }}</option>
                        @endforeach
                    </select>
                    <input name="nama" placeholder="Nama Kecamatan" class="w-full form-input rounded border-gray-300">
                    <input name="kode" placeholder="Kode" class="w-full form-input rounded border-gray-300">
                    <button type="submit" class="w-full bg-blue-600 text-black py-2 rounded hover:bg-blue-700">Tambah</button>
                </form>
            </div>

            {{-- Kelurahan --}}
            <div class="bg-white p-4 rounded-xl shadow">
                <h2 class="text-lg font-semibold mb-3">Tambah Kelurahan/Desa</h2>
                <form method="POST" action="{{ route('admin.kelurahan.store') }}" class="space-y-2">
                    @csrf
                    <select name="kecamatan_id" class="w-full form-select rounded border-gray-300">
                        <option value="">-- Pilih Kecamatan --</option>
                        @foreach ($kecamatans as $kec)
                            <option value="{{ $kec->id }}">{{ $kec->nama }}</option>
                        @endforeach
                    </select>
                    <input name="nama" placeholder="Nama Kelurahan/Desa" class="w-full form-input rounded border-gray-300">
                    <input name="kode" placeholder="Kode" class="w-full form-input rounded border-gray-300">
                    <button type="submit" class="w-full bg-blue-600 text-black py-2 rounded hover:bg-blue-700">Tambah</button>
                </form>
            </div>
        </div>

        {{-- === TABEL DATA === --}}
        <div class="space-y-8">
            {{-- Tabel Provinsi --}}
            <div class="bg-white rounded-lg shadow overflow-x-auto">
                <h3 class="px-4 py-3 border-b text-lg font-semibold">Daftar Provinsi</h3>
                <table class="min-w-full text-sm text-gray-800">
                    <thead class="bg-gray-50 text-xs font-semibold uppercase text-gray-600">
                        <tr><th class="px-4 py-2">Nama</th><th class="px-4 py-2">Kode</th></tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($provinsis as $item)
                            <tr><td class="px-4 py-2">{{ $item->nama }}</td><td class="px-4 py-2">{{ $item->kode }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Tabel Kabupaten/Kota --}}
            <div class="bg-white rounded-lg shadow overflow-x-auto">
                <h3 class="px-4 py-3 border-b text-lg font-semibold">Daftar Kabupaten/Kota</h3>
                <table class="min-w-full text-sm text-gray-800">
                    <thead class="bg-gray-50 text-xs font-semibold uppercase text-gray-600">
                        <tr>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">Kode</th>
                            <th class="px-4 py-2">Provinsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($kabupatens as $item)
                            <tr>
                                <td class="px-4 py-2">{{ $item->nama }}</td>
                                <td class="px-4 py-2">{{ $item->kode }}</td>
                                <td class="px-4 py-2">{{ $item->provinsi->nama ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Tabel Kecamatan --}}
            <div class="bg-white rounded-lg shadow overflow-x-auto">
                <h3 class="px-4 py-3 border-b text-lg font-semibold">Daftar Kecamatan</h3>
                <table class="min-w-full text-sm text-gray-800">
                    <thead class="bg-gray-50 text-xs font-semibold uppercase text-gray-600">
                        <tr>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">Kode</th>
                            <th class="px-4 py-2">Kabupaten/Kota</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($kecamatans as $item)
                            <tr>
                                <td class="px-4 py-2">{{ $item->nama }}</td>
                                <td class="px-4 py-2">{{ $item->kode }}</td>
                                <td class="px-4 py-2">{{ $item->kabupatenKota->nama ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Tabel Kelurahan --}}
            <div class="bg-white rounded-lg shadow overflow-x-auto">
                <h3 class="px-4 py-3 border-b text-lg font-semibold">Daftar Kelurahan / Desa</h3>
                <table class="min-w-full text-sm text-gray-800">
                    <thead class="bg-gray-50 text-xs font-semibold uppercase text-gray-600">
                        <tr>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">Kode</th>
                            <th class="px-4 py-2">Kecamatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($kelurahans as $item)
                            <tr>
                                <td class="px-4 py-2">{{ $item->nama }}</td>
                                <td class="px-4 py-2">{{ $item->kode }}</td>
                                <td class="px-4 py-2">{{ $item->kecamatan->nama ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</body>
</html>
