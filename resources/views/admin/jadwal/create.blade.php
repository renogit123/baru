<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Tambah Jadwal Pelatihan</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
        <form method="POST" action="{{ route('admin.jadwal-pelatihan.store') }}">
            @csrf

            <x-input-label for="judul" value="Judul Pelatihan" />
            <x-text-input name="judul" class="w-full mb-4" value="{{ old('judul') }}" />

            <x-input-label for="tgl_mulai" value="Tanggal Mulai" />
            <x-text-input name="tgl_mulai" type="date" class="w-full mb-4" value="{{ old('tgl_mulai') }}" />

            <x-input-label for="tgl_selesai" value="Tanggal Selesai" />
            <x-text-input name="tgl_selesai" type="date" class="w-full mb-4" value="{{ old('tgl_selesai') }}" />

            <x-input-label for="pembiayaan" value="Pembiayaan" />
            <select name="pembiayaan" class="w-full mb-4">
                <option value="RM">RM</option>
                <option value="PNBP">PNBP</option>
            </select>

            <x-input-label for="kelas" value="Kelas" />
            <x-text-input name="kelas" class="w-full mb-4" value="{{ old('kelas') }}" />

            <x-input-label for="status" value="Status (Aktif?)" />
            <select name="status" class="w-full mb-4">
                <option value="1">Aktif</option>
                <option value="0">Tidak Aktif</option>
            </select>

            <x-primary-button>Simpan</x-primary-button>
        </form>
    </div>
</x-app-layout>
