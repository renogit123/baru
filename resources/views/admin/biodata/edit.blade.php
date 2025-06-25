<x-admin-layout>
    <h2 class="text-xl font-semibold text-white mb-6">Edit Biodata User</h2>

    <div class="max-w-4xl mx-auto p-6 bg-white/5 rounded shadow border border-white/10 backdrop-blur text-white">
        <form method="POST" action="{{ route('admin.user.biodata.update', $user->id) }}">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <x-input-label for="nama" value="Nama" class="text-white/80" />
            <x-text-input name="nama" id="nama" class="block w-full mb-4 text-black" value="{{ old('nama', $biodata->nama ?? '') }}" />

            {{-- Alamat --}}
            <x-input-label for="alamat" value="Alamat" class="text-white/80" />
            <textarea name="alamat" id="alamat" class="block w-full mb-4 border rounded text-black">{{ old('alamat', $biodata->alamat ?? '') }}</textarea>

            {{-- ID Desa --}}
            <x-input-label for="id_desa" value="Desa/Kelurahan" class="text-white/80" />
            <select name="id_desa" id="id_desa" class="block w-full mb-4 rounded text-black">
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
            <x-input-label for="nik" value="NIK" class="text-white/80" />
            <x-text-input name="nik" id="nik" class="block w-full mb-4 text-black" value="{{ old('nik', $biodata->nik ?? '') }}" />

            {{-- Tempat & Tanggal Lahir --}}
            <x-input-label for="tempat_lahir" value="Tempat Lahir" class="text-white/80" />
            <x-text-input name="tempat_lahir" id="tempat_lahir" class="block w-full mb-4 text-black" value="{{ old('tempat_lahir', $biodata->tempat_lahir ?? '') }}" />

            <x-input-label for="tanggal_lahir" value="Tanggal Lahir" class="text-white/80" />
            <x-text-input name="tanggal_lahir" id="tanggal_lahir" type="date" class="block w-full mb-4 text-black" value="{{ old('tanggal_lahir', $biodata->tanggal_lahir ?? '') }}" />

            {{-- Jenis Kelamin --}}
            <x-input-label for="jenis_kelamin" value="Jenis Kelamin" class="text-white/80" />
            <select name="jenis_kelamin" class="block w-full mb-4 rounded text-black">
                <option value="Laki-laki" {{ old('jenis_kelamin', $biodata->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin', $biodata->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>

            {{-- Status Kawin --}}
            <x-input-label for="status_kawin" value="Status Kawin" class="text-white/80" />
            <select name="status_kawin" class="block w-full mb-4 rounded text-black">
                @foreach(['Kawin', 'Belum Kawin', 'Cerai Hidup', 'Cerai Mati'] as $status)
                    <option value="{{ $status }}" {{ old('status_kawin', $biodata->status_kawin ?? '') == $status ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>

            {{-- Jabatan --}}
            <x-input-label for="jabatan" value="Jabatan" class="text-white/80" />
            <x-text-input name="jabatan" id="jabatan" class="block w-full mb-4 text-black" value="{{ old('jabatan', $biodata->jabatan ?? '') }}" />

            {{-- Lama Menjabat --}}
            <x-input-label for="lama_menjabat" value="Lama Menjabat (Tahun)" class="text-white/80" />
            <x-text-input name="lama_menjabat" id="lama_menjabat" class="block w-full mb-4 text-black" value="{{ old('lama_menjabat', $biodata->lama_menjabat ?? '') }}" />

            {{-- Nomor SK --}}
            <x-input-label for="nomor_sk_jabatan" value="Nomor SK Jabatan" class="text-white/80" />
            <x-text-input name="nomor_sk_jabatan" id="nomor_sk_jabatan" class="block w-full mb-4 text-black" value="{{ old('nomor_sk_jabatan', $biodata->nomor_sk_jabatan ?? '') }}" />

            {{-- Pendidikan --}}
            <x-input-label for="pendidikan" value="Pendidikan" class="text-white/80" />
            <x-text-input name="pendidikan" id="pendidikan" class="block w-full mb-4 text-black" value="{{ old('pendidikan', $biodata->pendidikan ?? '') }}" />

            {{-- No Telp --}}
            <x-input-label for="no_telp" value="No Telepon" class="text-white/80" />
            <x-text-input name="no_telp" id="no_telp" class="block w-full mb-4 text-black" value="{{ old('no_telp', $biodata->no_telp ?? '') }}" />

            <div class="mt-4">
                <x-primary-button>Simpan Perubahan</x-primary-button>
                <a href="{{ route('admin.dashboard') }}" class="ml-4 text-sm text-white/70 hover:underline">← Kembali</a>
            </div>
        </form>
    </div>
</x-admin-layout>
