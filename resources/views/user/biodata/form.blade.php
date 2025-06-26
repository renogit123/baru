<x-user-layout>
    <div class="max-w-4xl mx-auto p-6 rounded-xl shadow-lg bg-sky-950 text-white ring-1 ring-white/10">
        <a href="{{ route('user.dashboard') }}"
           class="inline-flex items-center mb-6 text-sm text-yellow-300 hover:text-white transition">
            ← Kembali ke Dashboard
        </a>

        <h2 class="text-2xl font-bold mb-6">📋 Form Biodata Peserta</h2>

        @if(session('success'))
            <div class="mb-4 text-green-300 font-semibold bg-green-900/40 p-2 rounded border border-green-600">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('user.biodata.store') }}">
            @csrf

            {{-- Nama --}}
            <x-input-label for="nama" value="Nama Peserta" class="text-white" />
            <x-text-input name="nama" id="nama" type="text"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white"
                value="{{ old('nama', $biodata->nama ?? '') }}" />

            {{-- Alamat --}}
            <x-input-label for="alamat" value="Alamat Peserta" class="text-white" />
            <textarea name="alamat" id="alamat"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white rounded">{{ old('alamat', $biodata->alamat ?? '') }}</textarea>

            {{-- ID Desa --}}
            <x-input-label for="id_desa" value="Desa/Kelurahan (pilih dari daftar)" class="text-white" />
            <input list="daftar-desa" name="id_desa" id="id_desa"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white rounded placeholder-white/50"
                value="{{ old('id_desa', $biodata->id_desa ?? '') }}"
                placeholder="contoh: desa/kel kec kab/kota prov" required>
            
            <datalist id="daftar-desa">
                @foreach($kelurahans as $desa)
                    <option value="{{ $desa->id }}">
                        {{ $desa->nama }}
                        @if($desa->kecamatan && $desa->kecamatan->kabupatenKota && $desa->kecamatan->kabupatenKota->provinsi)
                            - {{ $desa->kecamatan->nama }}
                            - {{ $desa->kecamatan->kabupatenKota->nama }}
                            - {{ $desa->kecamatan->kabupatenKota->provinsi->nama }}
                        @endif
                    </option>
                @endforeach
            </datalist>

            {{-- Wilayah Otomatis --}}
            <x-input-label value="Provinsi" class="text-white" />
            <input type="text" id="provinsi" name="provinsi" readonly
                class="block w-full mb-2 bg-sky-800 border border-white/20 text-white rounded">

            <x-input-label value="Kabupaten/Kota" class="text-white" />
            <input type="text" id="kabupaten" name="kabupaten" readonly
                class="block w-full mb-2 bg-sky-800 border border-white/20 text-white rounded">

            <x-input-label value="Kecamatan" class="text-white" />
            <input type="text" id="kecamatan" name="kecamatan" readonly
                class="block w-full mb-2 bg-sky-800 border border-white/20 text-white rounded">

            <x-input-label value="Desa/Kelurahan" class="text-white" />
            <input type="text" id="desa" name="desa" readonly
                class="block w-full mb-2 bg-sky-800 border border-white/20 text-white rounded">

            <x-input-label value="Kode Desa" class="text-white" />
            <input type="text" id="kode_desa" name="kode_desa" readonly
                class="block w-full mb-4 bg-sky-800 border border-white/20 text-white rounded">

            {{-- NIK --}}
            <x-input-label for="nik" value="NIK" class="text-white" />
            <x-text-input name="nik" id="nik" type="text"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white"
                value="{{ old('nik', $biodata->nik ?? '') }}" />

            {{-- NPWP --}}
            <x-input-label for="npwp" value="NPWP (opsional)" class="text-white" />
            <x-text-input name="npwp" id="npwp" type="text"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white"
                value="{{ old('npwp', $biodata->npwp ?? '') }}" />

            {{-- Tempat Lahir --}}
            <x-input-label for="tempat_lahir" value="Tempat Lahir" class="text-white" />
            <x-text-input name="tempat_lahir" id="tempat_lahir" type="text"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white"
                value="{{ old('tempat_lahir', $biodata->tempat_lahir ?? '') }}" />

            {{-- Tanggal Lahir --}}
            <x-input-label for="tanggal_lahir" value="Tanggal Lahir" class="text-white" />
            <x-text-input name="tanggal_lahir" id="tanggal_lahir" type="date"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white"
                value="{{ old('tanggal_lahir', $biodata->tanggal_lahir ?? '') }}" />

            {{-- Jenis Kelamin --}}
            <x-input-label for="jenis_kelamin" value="Jenis Kelamin" class="text-white" />
            <select name="jenis_kelamin" id="jenis_kelamin"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white rounded">
                <option value="">-- Pilih --</option>
                <option value="Laki-laki" {{ old('jenis_kelamin', $biodata->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin', $biodata->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>

            {{-- Agama --}}
            <x-input-label for="agama" value="Agama" class="text-white" />
            <select name="agama" id="agama"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white rounded">
                <option value="">-- Pilih --</option>
                @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu','Lainnya'] as $agama)
                    <option value="{{ $agama }}" {{ old('agama', $biodata->agama ?? '') == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                @endforeach
            </select>

            {{-- Status Kawin --}}
            <x-input-label for="status_kawin" value="Status Kawin" class="text-white" />
            <select name="status_kawin" id="status_kawin"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white rounded">
                <option value="">-- Pilih --</option>
                @foreach(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $status)
                    <option value="{{ $status }}" {{ old('status_kawin', $biodata->status_kawin ?? '') == $status ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>

            {{-- Jabatan --}}
            <x-input-label for="jabatan" value="Jabatan" class="text-white" />
            <x-text-input name="jabatan" id="jabatan" type="text"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white"
                value="{{ old('jabatan', $biodata->jabatan ?? '') }}" />

            {{-- Lama Menjabat --}}
            <x-input-label for="lama_menjabat" value="Lama Menjabat (tahun)" class="text-white" />
            <x-text-input name="lama_menjabat" id="lama_menjabat" type="number"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white"
                value="{{ old('lama_menjabat', $biodata->lama_menjabat ?? '') }}" />

            {{-- Nomor SK --}}
            <x-input-label for="nomor_sk_jabatan" value="Nomor SK Jabatan" class="text-white" />
            <x-text-input name="nomor_sk_jabatan" id="nomor_sk_jabatan" type="text"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white"
                value="{{ old('nomor_sk_jabatan', $biodata->nomor_sk_jabatan ?? '') }}" />

            {{-- Pendidikan --}}
            <x-input-label for="pendidikan" value="Pendidikan" class="text-white" />
            <select name="pendidikan" id="pendidikan"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white rounded">
                <option value="">-- Pilih --</option>
                @foreach(['SD', 'SMP', 'SMA', 'Diploma', 'Sarjana', 'Magister', 'Doktor', 'Lainnya'] as $edu)
                    <option value="{{ $edu }}" {{ old('pendidikan', $biodata->pendidikan ?? '') == $edu ? 'selected' : '' }}>{{ $edu }}</option>
                @endforeach
            </select>

            {{-- No Telp --}}
            <x-input-label for="no_telp" value="No Telepon" class="text-white" />
            <x-text-input name="no_telp" id="no_telp" type="text"
                class="block w-full mb-6 bg-sky-900 border border-white/20 text-white"
                value="{{ old('no_telp', $biodata->no_telp ?? '') }}" />

            <x-primary-button class="bg-green-700 text-white font-bold px-6 py-2 rounded shadow">
                💾 Simpan
            </x-primary-button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const idDesaInput = document.getElementById('id_desa');
    
            idDesaInput.addEventListener('change', () => {
                const id = idDesaInput.value;
    
                if (!id) return;
    
                fetch(`/api/desa/${id}`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('provinsi').value = data.provinsi ?? '';
                        document.getElementById('kabupaten').value = data.kabupaten ?? '';
                        document.getElementById('kecamatan').value = data.kecamatan ?? '';
                        document.getElementById('desa').value = data.desa ?? '';
                        document.getElementById('kode_desa').value = data.kode_desa ?? '';
                    })
                    .catch(err => {
                        console.error('Gagal ambil data wilayah:', err);
                        alert('Gagal mengambil data wilayah.');
                    });
            });
    
            // Auto-isi ulang data wilayah saat reload/form error
            const oldIdDesa = '{{ old('id_desa', $biodata->id_desa ?? '') }}';
            if (oldIdDesa) {
                fetch(`/api/desa/${oldIdDesa}`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('provinsi').value = data.provinsi ?? '';
                        document.getElementById('kabupaten').value = data.kabupaten ?? '';
                        document.getElementById('kecamatan').value = data.kecamatan ?? '';
                        document.getElementById('desa').value = data.desa ?? '';
                        document.getElementById('kode_desa').value = data.kode_desa ?? '';
                    })
                    .catch(err => {
                        console.error('Gagal ambil data wilayah saat load:', err);
                    });
            }
        });
    </script>
    
</x-user-layout>
