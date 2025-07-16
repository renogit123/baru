<x-user-layout>
    <div class="max-w-4xl mx-auto p-8 rounded-2xl shadow-xl bg-gradient-to-br from-sky-900 to-sky-950 text-white ring-1 ring-yellow-400/20">
        <a href="{{ route('user.dashboard') }}"
           class="inline-flex items-center mb-6 text-sm text-yellow-300 hover:underline">
            ← Kembali ke Dashboard
        </a>

        <h2 class="text-3xl font-extrabold mb-8 text-yellow-300 tracking-wide">
            📋 Form Biodata Peserta
        </h2>

        @if(session('success'))
            <div class="mb-4 bg-green-800/30 text-green-300 font-medium p-3 rounded-lg border border-green-600 shadow">
                ✅ {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('user.biodata.store') }}" class="space-y-4">
            @csrf

            {{-- Nama --}}
            <div>
                <label for="nama" class="block font-semibold text-yellow-200">Nama Peserta</label>
                <x-text-input id="nama" name="nama" type="text"
                    class="bg-sky-900 border border-yellow-400/30 rounded-lg w-full text-white"
                    value="{{ old('nama', $biodata->nama ?? '') }}" />
            </div>

            {{-- Alamat --}}
            <div>
                <label for="alamat" class="block font-semibold text-yellow-200">Alamat Peserta</label>
                <textarea id="alamat" name="alamat" rows="3"
                    class="bg-sky-900 border border-yellow-400/30 rounded-lg w-full text-white">{{ old('alamat', $biodata->alamat ?? '') }}</textarea>
            </div>

            {{-- Desa/Kelurahan Search --}}
            <div class="relative">
                <label for="id_desa" class="block font-semibold text-yellow-200">Desa/Kelurahan</label>
                <input type="text" id="desa_search" placeholder="Ketik nama desa..."
                    class="bg-sky-900 border border-yellow-400/30 rounded-lg w-full text-white placeholder-white/50"
                    autocomplete="off">
                <input type="hidden" name="id_desa" id="id_desa" value="{{ old('id_desa', $biodata->id_desa ?? '') }}">

                <ul id="desa_results"
                    class="absolute z-10 mt-1 w-full bg-sky-800 border border-yellow-400/30 rounded-lg text-white max-h-52 overflow-y-auto hidden">
                </ul>
            </div>

            {{-- Wilayah Otomatis --}}
            @foreach (['provinsi', 'kabupaten', 'kecamatan', 'desa', 'kode_desa'] as $field)
                <div>
                    <label class="block font-semibold text-yellow-200">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                    <input type="text" id="{{ $field }}" name="{{ $field }}" readonly
                        class="bg-sky-800 border border-yellow-400/20 rounded-lg w-full text-white">
                </div>
            @endforeach

            {{-- Input Lainnya --}}
            @php
                $fields = [
                    'nik' => 'NIK', 'npwp' => 'NPWP (opsional)', 'tempat_lahir' => 'Tempat Lahir',
                    'tanggal_lahir' => 'Tanggal Lahir', 'jabatan' => 'Jabatan',
                    'lama_menjabat' => 'Lama Menjabat (tahun)', 'nomor_sk_jabatan' => 'Nomor SK Jabatan',
                    'no_telp' => 'No Telepon'
                ];
            @endphp

            @foreach($fields as $key => $label)
                <div>
                    <label for="{{ $key }}" class="block font-semibold text-yellow-200">{{ $label }}</label>
                    <x-text-input id="{{ $key }}" name="{{ $key }}" type="{{ $key === 'tanggal_lahir' ? 'date' : ($key === 'lama_menjabat' ? 'number' : 'text') }}"
                        class="bg-sky-900 border border-yellow-400/30 rounded-lg w-full text-white"
                        value="{{ old($key, $biodata->$key ?? '') }}" />
                </div>
            @endforeach

            {{-- Dropdown --}}
            @php
                $dropdowns = [
                    'jenis_kelamin' => ['Laki-laki', 'Perempuan'],
                    'agama' => ['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu','Lainnya'],
                    'status_kawin' => ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'],
                    'pendidikan' => ['SD','SMP','SMA','Diploma','Sarjana','Magister','Doktor','Lainnya']
                ];
            @endphp

            @foreach ($dropdowns as $name => $options)
                <div>
                    <label for="{{ $name }}" class="block font-semibold text-yellow-200">{{ ucwords(str_replace('_', ' ', $name)) }}</label>
                    <select id="{{ $name }}" name="{{ $name }}"
                        class="bg-sky-900 border border-yellow-400/30 rounded-lg w-full text-white">
                        <option value="">-- Pilih --</option>
                        @foreach ($options as $opt)
                            <option value="{{ $opt }}" {{ old($name, $biodata->$name ?? '') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>
            @endforeach

            {{-- Tombol Simpan --}}
            <div class="pt-6 text-center">
                <x-primary-button class="bg-yellow-400 hover:bg-yellow-300 text-sky-900 font-bold px-8 py-3 rounded-xl shadow-lg transition hover:-translate-y-1">
                    💾 Simpan Biodata
                </x-primary-button>
            </div>
        </form>
    </div>

    {{-- Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const desaSearch = document.getElementById('desa_search');
            const desaResults = document.getElementById('desa_results');
            const idDesaInput = document.getElementById('id_desa');

            desaSearch.addEventListener('input', function () {
                const query = this.value;
                if (query.length < 3) {
                    desaResults.innerHTML = '';
                    desaResults.classList.add('hidden');
                    return;
                }

                fetch(`/api/search-desa?q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(data => {
                        desaResults.innerHTML = '';
                        if (data.length === 0) {
                            desaResults.classList.add('hidden');
                            return;
                        }

                        data.forEach(item => {
                            const li = document.createElement('li');
                            li.textContent = `${item.nama} - ${item.kecamatan} - ${item.kabupaten} - ${item.provinsi}`;
                            li.classList.add('cursor-pointer', 'px-4', 'py-2', 'hover:bg-sky-700');
                            li.addEventListener('click', () => {
                                desaSearch.value = li.textContent;
                                idDesaInput.value = item.id;
                                desaResults.classList.add('hidden');

                                fetch(`/api/desa/${item.id}`)
                                    .then(res => res.json())
                                    .then(data => {
                                        ['provinsi','kabupaten','kecamatan','desa','kode_desa'].forEach(field => {
                                            document.getElementById(field).value = data[field] ?? '';
                                        });
                                    });
                            });
                            desaResults.appendChild(li);
                        });

                        desaResults.classList.remove('hidden');
                    });
            });

            document.addEventListener('click', (e) => {
                if (!desaSearch.contains(e.target) && !desaResults.contains(e.target)) {
                    desaResults.classList.add('hidden');
                }
            });

            const oldIdDesa = '{{ old('id_desa', $biodata->id_desa ?? '') }}';
            if (oldIdDesa) {
                fetch(`/api/desa/${oldIdDesa}`)
                    .then(res => res.json())
                    .then(data => {
                        ['provinsi','kabupaten','kecamatan','desa','kode_desa'].forEach(field => {
                            document.getElementById(field).value = data[field] ?? '';
                        });

                        // tampilkan kembali di input search
                        document.getElementById('desa_search').value =
                            `${data.desa} - ${data.kecamatan} - ${data.kabupaten} - ${data.provinsi}`;
                    });
            }
        });
    </script>
</x-user-layout>
