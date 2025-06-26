<x-admin-layout>
    <h2 class="text-2xl font-bold text-white mb-6">📋 Edit Biodata User</h2>

    <div class="max-w-4xl mx-auto p-6 bg-sky-950 rounded-xl shadow-lg text-white ring-1 ring-white/10">
        <form method="POST" action="{{ route('admin.user.biodata.update', $user->id) }}">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <x-input-label for="nama" value="Nama" class="text-white" />
            <x-text-input name="nama" id="nama" class="block w-full mb-4 bg-sky-900 border border-white/20 text-white"
                value="{{ old('nama', $biodata->nama ?? '') }}" />

            {{-- Alamat --}}
            <x-input-label for="alamat" value="Alamat" class="text-white" />
            <textarea name="alamat" id="alamat" class="block w-full mb-4 bg-sky-900 border border-white/20 text-white rounded">{{ old('alamat', $biodata->alamat ?? '') }}</textarea>

            {{-- ID Desa --}}
            <x-input-label for="id_desa" value="Desa/Kelurahan (pilih dari daftar)" class="text-white" />
            <input list="daftar-desa" name="id_desa" id="id_desa"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white rounded"
                value="{{ old('id_desa', $biodata->id_desa ?? '') }}">
            <datalist id="daftar-desa">
                @foreach($kelurahans as $desa)
                    <option value="{{ $desa->id }}">
                        {{ $desa->nama }},
                        {{ $desa->kecamatan->nama ?? '' }},
                        {{ $desa->kecamatan->kabupatenKota->nama ?? '' }},
                        {{ $desa->kecamatan->kabupatenKota->provinsi->nama ?? '' }}
                    </option>
                @endforeach
            </datalist>

            {{-- Wilayah Otomatis --}}
            <x-input-label value="Provinsi" class="text-white" />
            <input type="text" id="provinsi" name="provinsi" readonly
                class="block w-full mb-2 bg-sky-800 border border-white/20 text-white rounded"
                value="{{ old('provinsi', $biodata->provinsi ?? '') }}">

            <x-input-label value="Kabupaten/Kota" class="text-white" />
            <input type="text" id="kabupaten" name="kabupaten" readonly
                class="block w-full mb-2 bg-sky-800 border border-white/20 text-white rounded"
                value="{{ old('kabupaten', $biodata->kabupaten ?? '') }}">

            <x-input-label value="Kecamatan" class="text-white" />
            <input type="text" id="kecamatan" name="kecamatan" readonly
                class="block w-full mb-2 bg-sky-800 border border-white/20 text-white rounded"
                value="{{ old('kecamatan', $biodata->kecamatan ?? '') }}">

            <x-input-label value="Kelurahan/Desa" class="text-white" />
            <input type="text" id="desa" name="kelurahan" readonly
                class="block w-full mb-2 bg-sky-800 border border-white/20 text-white rounded"
                value="{{ old('kelurahan', $biodata->kelurahan ?? '') }}">

            <x-input-label value="Kode Desa" class="text-white" />
            <input type="text" id="kode_desa" name="kode_desa" readonly
                class="block w-full mb-4 bg-sky-800 border border-white/20 text-white rounded"
                value="{{ old('kode_desa', $biodata->kode_desa ?? '') }}">

            {{-- NIK --}}
            <x-input-label for="nik" value="NIK" class="text-white" />
            <x-text-input name="nik" id="nik"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white"
                value="{{ old('nik', $biodata->nik ?? '') }}" />

            {{-- Tempat Lahir --}}
            <x-input-label for="tempat_lahir" value="Tempat Lahir" class="text-white" />
            <x-text-input name="tempat_lahir" id="tempat_lahir"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white"
                value="{{ old('tempat_lahir', $biodata->tempat_lahir ?? '') }}" />

            {{-- Tanggal Lahir --}}
            <x-input-label for="tanggal_lahir" value="Tanggal Lahir" class="text-white" />
            <x-text-input name="tanggal_lahir" id="tanggal_lahir" type="date"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white"
                value="{{ old('tanggal_lahir', $biodata->tanggal_lahir ?? '') }}" />

            {{-- Jenis Kelamin --}}
            <x-input-label for="jenis_kelamin" value="Jenis Kelamin" class="text-white" />
            <select name="jenis_kelamin"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white rounded">
                <option value="Laki-laki" {{ old('jenis_kelamin', $biodata->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin', $biodata->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>

            {{-- Status Kawin --}}
            <x-input-label for="status_kawin" value="Status Kawin" class="text-white" />
            <select name="status_kawin"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white rounded">
                @foreach(['Kawin', 'Belum Kawin', 'Cerai Hidup', 'Cerai Mati'] as $status)
                    <option value="{{ $status }}" {{ old('status_kawin', $biodata->status_kawin ?? '') == $status ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>

            {{-- Jabatan --}}
            <x-input-label for="jabatan" value="Jabatan" class="text-white" />
            <x-text-input name="jabatan" id="jabatan"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white"
                value="{{ old('jabatan', $biodata->jabatan ?? '') }}" />

            {{-- Lama Menjabat --}}
            <x-input-label for="lama_menjabat" value="Lama Menjabat (Tahun)" class="text-white" />
            <x-text-input name="lama_menjabat" id="lama_menjabat"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white"
                value="{{ old('lama_menjabat', $biodata->lama_menjabat ?? '') }}" />

            {{-- Nomor SK --}}
            <x-input-label for="nomor_sk_jabatan" value="Nomor SK Jabatan" class="text-white" />
            <x-text-input name="nomor_sk_jabatan" id="nomor_sk_jabatan"
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
            <x-text-input name="no_telp" id="no_telp"
                class="block w-full mb-6 bg-sky-900 border border-white/20 text-white"
                value="{{ old('no_telp', $biodata->no_telp ?? '') }}" />

            <x-primary-button class="bg-green-700 text-white font-bold px-6 py-2 rounded shadow">
                💾 Simpan Perubahan
            </x-primary-button>
            <a href="{{ route('admin.dashboard') }}" class="ml-4 text-sm text-white/70 hover:underline">← Kembali</a>
        </form>
    </div>

    {{-- SCRIPT --}}
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
                        alert('Gagal mengambil data wilayah.');
                        console.error(err);
                    });
            });

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
                    });
            }
        });
    </script>
</x-admin-layout>
