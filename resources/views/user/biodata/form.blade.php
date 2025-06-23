<x-app-layout>
    <div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
        <h2 class="text-xl font-semibold mb-4">Form Biodata Peserta</h2>
    
        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif
    
        <form method="POST" action="{{ route('user.biodata.store') }}">
            @csrf
    
            {{-- Nama --}}
            <x-input-label for="nama" value="Nama Peserta" />
            <x-text-input name="nama" id="nama" type="text" class="block w-full mb-4"
                          value="{{ old('nama', $biodata->nama ?? '') }}" />
    
            {{-- Alamat --}}
            <x-input-label for="alamat" value="Alamat Peserta" />
            <textarea name="alamat" id="alamat"
                      class="block w-full mb-4 border-gray-300 rounded">{{ old('alamat', $biodata->alamat ?? '') }}</textarea>
    
            {{-- ID Desa (dengan relasi lengkap) --}}
            <x-input-label for="id_desa" :value="'Desa/Kelurahan'" />
            <input list="daftar-desa" name="id_desa" id="id_desa"
                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                value="{{ old('id_desa', $biodata->id_desa ?? '') }}"
                required>
            
            <datalist id="daftar-desa">
                @foreach($kelurahans as $desa)
                    <option 
                        value="{{ $desa->id }}">
                        {{ $desa->nama }} - {{ $desa->kecamatan->nama ?? '' }} - {{ $desa->kecamatan->kabupatenKota->nama ?? '' }} - {{ $desa->kecamatan->kabupatenKota->provinsi->nama ?? '' }}
                    </option>
                @endforeach
            </datalist>
            
            <x-input-error :messages="$errors->get('id_desa')" class="mt-2" />
    
            {{-- NIK --}}
            <x-input-label for="nik" value="NIK" />
            <x-text-input name="nik" id="nik" type="text" class="block w-full mb-4"
                          value="{{ old('nik', $biodata->nik ?? '') }}" />
    
            {{-- NPWP --}}
            <x-input-label for="npwp" value="NPWP (opsional)" />
            <x-text-input name="npwp" id="npwp" type="text" class="block w-full mb-4"
                          value="{{ old('npwp', $biodata->npwp ?? '') }}" />
    
            {{-- Tempat Lahir --}}
            <x-input-label for="tempat_lahir" value="Tempat Lahir" />
            <x-text-input name="tempat_lahir" id="tempat_lahir" type="text" class="block w-full mb-4"
                          value="{{ old('tempat_lahir', $biodata->tempat_lahir ?? '') }}" />
    
            {{-- Tanggal Lahir --}}
            <x-input-label for="tanggal_lahir" value="Tanggal Lahir" />
            <x-text-input name="tanggal_lahir" id="tanggal_lahir" type="date" class="block w-full mb-4"
                          value="{{ old('tanggal_lahir', $biodata->tanggal_lahir ?? '') }}" />
    
            {{-- Jenis Kelamin --}}
            <x-input-label for="jenis_kelamin" value="Jenis Kelamin" />
            <select name="jenis_kelamin" id="jenis_kelamin" class="block w-full mb-4">
                <option value="">-- Pilih --</option>
                <option value="Laki-laki" {{ old('jenis_kelamin', $biodata->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin', $biodata->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
    
            {{-- Agama --}}
            <x-input-label for="agama" value="Agama" />
            <select name="agama" id="agama" class="block w-full mb-4">
                <option value="">-- Pilih --</option>
                @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu','Lainnya'] as $agama)
                    <option value="{{ $agama }}" {{ old('agama', $biodata->agama ?? '') == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                @endforeach
            </select>
    
            {{-- Status Kawin --}}
            <x-input-label for="status_kawin" value="Status Kawin" />
            <select name="status_kawin" id="status_kawin" class="block w-full mb-4">
                <option value="">-- Pilih --</option>
                @foreach(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $status)
                    <option value="{{ $status }}" {{ old('status_kawin', $biodata->status_kawin ?? '') == $status ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>
    
            {{-- Jabatan --}}
            <x-input-label for="jabatan" value="Jabatan" />
            <x-text-input name="jabatan" id="jabatan" type="text" class="block w-full mb-4"
                          value="{{ old('jabatan', $biodata->jabatan ?? '') }}" />
    
            {{-- Lama Menjabat --}}
            <x-input-label for="lama_menjabat" value="Lama Menjabat (dalam tahun)" />
            <x-text-input name="lama_menjabat" id="lama_menjabat" type="number" class="block w-full mb-4"
                          value="{{ old('lama_menjabat', $biodata->lama_menjabat ?? '') }}" />
    
            {{-- Nomor SK --}}
            <x-input-label for="nomor_sk_jabatan" value="Nomor SK Jabatan" />
            <x-text-input name="nomor_sk_jabatan" id="nomor_sk_jabatan" type="text" class="block w-full mb-4"
                          value="{{ old('nomor_sk_jabatan', $biodata->nomor_sk_jabatan ?? '') }}" />
    
            {{-- Pendidikan --}}
            <x-input-label for="pendidikan" value="Pendidikan" />
            <select name="pendidikan" id="pendidikan" class="block w-full mb-4">
                <option value="">-- Pilih --</option>
                @foreach(['SD', 'SMP', 'SMA', 'Diploma', 'Sarjana', 'Magister', 'Doktor', 'Lainnya'] as $edu)
                    <option value="{{ $edu }}" {{ old('pendidikan', $biodata->pendidikan ?? '') == $edu ? 'selected' : '' }}>{{ $edu }}</option>
                @endforeach
            </select>
    
            {{-- No Telp --}}
            <x-input-label for="no_telp" value="No Telepon" />
            <x-text-input name="no_telp" id="no_telp" type="text" class="block w-full mb-4"
                          value="{{ old('no_telp', $biodata->no_telp ?? '') }}" />
    
            {{-- Tombol Simpan --}}
            <x-primary-button>Simpan</x-primary-button>
        </form>
    </div>
    </x-app-layout>
    