<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Edit Biodata User</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
        <form method="POST" action="{{ route('admin.user.biodata.update', $user->id) }}">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <x-input-label for="nama" value="Nama" />
            <x-text-input name="nama" id="nama" class="block w-full mb-4" value="{{ old('nama', $biodata->nama ?? '') }}" />

            {{-- Alamat --}}
            <x-input-label for="alamat" value="Alamat" />
            <textarea name="alamat" id="alamat" class="block w-full mb-4 border-gray-300 rounded">{{ old('alamat', $biodata->alamat ?? '') }}</textarea>

            {{-- ID Desa --}}
            <x-input-label for="id_desa" value="Desa/Kelurahan" />
            <select name="id_desa" id="id_desa" class="block w-full mb-4 border-gray-300 rounded">
                <option value="">-- Pilih Desa --</option>
                @foreach($kelurahans as $desa)
                    <option value="{{ $desa->id }}" {{ old('id_desa', $biodata->id_desa ?? '') == $desa->id ? 'selected' : '' }}>
                        {{ $desa->nama }},
                        {{ $desa->kecamatan->nama ?? '' }},
                        {{ $desa->kecamatan->kabupatenKota->nama ?? '' }},
                        {{ $desa->kecamatan->kabupatenKota->provinsi->nama ?? '' }}
                    </option>
                @endforeach
            </select>

            {{-- NIK --}}
            <x-input-label for="nik" value="NIK" />
            <x-text-input name="nik" id="nik" class="block w-full mb-4" value="{{ old('nik', $biodata->nik ?? '') }}" />

            {{-- Tempat & Tanggal Lahir --}}
            <x-input-label for="tempat_lahir" value="Tempat Lahir" />
            <x-text-input name="tempat_lahir" id="tempat_lahir" class="block w-full mb-4" value="{{ old('tempat_lahir', $biodata->tempat_lahir ?? '') }}" />

            <x-input-label for="tanggal_lahir" value="Tanggal Lahir" />
            <x-text-input name="tanggal_lahir" id="tanggal_lahir" type="date" class="block w-full mb-4" value="{{ old('tanggal_lahir', $biodata->tanggal_lahir ?? '') }}" />

            {{-- Jenis Kelamin --}}
            <x-input-label for="jenis_kelamin" value="Jenis Kelamin" />
            <select name="jenis_kelamin" class="block w-full mb-4">
                <option value="Laki-laki" {{ old('jenis_kelamin', $biodata->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin', $biodata->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>

            {{-- Status Kawin --}}
            <x-input-label for="status_kawin" value="Status Kawin" />
            <select name="status_kawin" class="block w-full mb-4">
                @foreach(['Kawin', 'Belum Kawin', 'Cerai Hidup', 'Cerai Mati'] as $status)
                    <option value="{{ $status }}" {{ old('status_kawin', $biodata->status_kawin ?? '') == $status ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>

            {{-- Jabatan --}}
            <x-input-label for="jabatan" value="Jabatan" />
            <x-text-input name="jabatan" id="jabatan" class="block w-full mb-4" value="{{ old('jabatan', $biodata->jabatan ?? '') }}" />

            {{-- Lama Menjabat --}}
            <x-input-label for="lama_menjabat" value="Lama Menjabat (Tahun)" />
            <x-text-input name="lama_menjabat" id="lama_menjabat" class="block w-full mb-4" value="{{ old('lama_menjabat', $biodata->lama_menjabat ?? '') }}" />

            {{-- Nomor SK --}}
            <x-input-label for="nomor_sk_jabatan" value="Nomor SK Jabatan" />
            <x-text-input name="nomor_sk_jabatan" id="nomor_sk_jabatan" class="block w-full mb-4" value="{{ old('nomor_sk_jabatan', $biodata->nomor_sk_jabatan ?? '') }}" />

            {{-- Pendidikan --}}
            <x-input-label for="pendidikan" value="Pendidikan" />
            <x-text-input name="pendidikan" id="pendidikan" class="block w-full mb-4" value="{{ old('pendidikan', $biodata->pendidikan ?? '') }}" />

            {{-- No Telp --}}
            <x-input-label for="no_telp" value="No Telepon" />
            <x-text-input name="no_telp" id="no_telp" class="block w-full mb-4" value="{{ old('no_telp', $biodata->no_telp ?? '') }}" />

            <x-primary-button>Simpan Perubahan</x-primary-button>
        </form>
    </div>
</x-app-layout>
