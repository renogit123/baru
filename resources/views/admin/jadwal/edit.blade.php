<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Edit Jadwal Pelatihan</h2>
    </x-slot>

    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <form method="POST" action="{{ route('admin.jadwal.update', $pelatihan->id) }}">
            @csrf
            @method('PUT')

            <x-input-label for="judul" value="Judul Pelatihan" />
            <x-text-input name="judul" class="w-full mb-4" value="{{ old('judul', $pelatihan->judul) }}" />

            <x-input-label for="tgl_mulai" value="Tanggal Mulai" />
            <x-text-input name="tgl_mulai" type="date" class="w-full mb-4" value="{{ old('tgl_mulai', $pelatihan->tgl_mulai) }}" />

            <x-input-label for="tgl_selesai" value="Tanggal Selesai" />
            <x-text-input name="tgl_selesai" type="date" class="w-full mb-4" value="{{ old('tgl_selesai', $pelatihan->tgl_selesai) }}" />

            <x-input-label for="pembiayaan" value="Pembiayaan" />
            <select name="pembiayaan" class="w-full mb-4">
                <option value="RM" {{ $pelatihan->pembiayaan == 'RM' ? 'selected' : '' }}>RM</option>
                <option value="PNBP" {{ $pelatihan->pembiayaan == 'PNBP' ? 'selected' : '' }}>PNBP</option>
            </select>

            <x-input-label for="kelas" value="Kelas" />
            <x-text-input name="kelas" class="w-full mb-4" value="{{ old('kelas', $pelatihan->kelas) }}" />

            <x-input-label for="status" value="Status" />
            <select name="status" class="w-full mb-4">
                <option value="1" {{ $pelatihan->status == 1 ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ $pelatihan->status == 0 ? 'selected' : '' }}>Tidak Aktif</option>
            </select>

            <x-primary-button>Simpan Perubahan</x-primary-button>
        </form>
    </div>
</x-app-layout>
