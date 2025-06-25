<x-admin-layout>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-white">✏️ Edit Jadwal Pelatihan</h2>
        <a href="{{ route('admin.jadwal-pelatihan.index') }}" class="text-sm text-white/70 hover:underline">⬅️ Kembali</a>
    </div>

    <div class="max-w-xl mx-auto bg-white/5 p-6 rounded shadow border border-white/10 backdrop-blur text-white">
        <form method="POST" action="{{ route('admin.jadwal-pelatihan.update', $pelatihan->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <x-input-label for="judul" value="Judul Pelatihan" class="text-white" />
                <x-text-input name="judul" id="judul" class="w-full mt-1 text-white" value="{{ old('judul', $pelatihan->judul) }}" />
            </div>

            <div class="mb-4">
                <x-input-label for="tgl_mulai" value="Tanggal Mulai" class="text-white" />
                <x-text-input name="tgl_mulai" type="date" id="tgl_mulai" class="w-full mt-1 text-white" value="{{ old('tgl_mulai', $pelatihan->tgl_mulai) }}" />
            </div>

            <div class="mb-4">
                <x-input-label for="tgl_selesai" value="Tanggal Selesai" class="text-white" />
                <x-text-input name="tgl_selesai" type="date" id="tgl_selesai" class="w-full mt-1 text-white" value="{{ old('tgl_selesai', $pelatihan->tgl_selesai) }}" />
            </div>

            <div class="mb-4">
                <x-input-label for="pembiayaan" value="Pembiayaan" class="text-white" />
                <select name="pembiayaan" id="pembiayaan" class="w-full mt-1 rounded text-black">
                    <option value="RM" {{ $pelatihan->pembiayaan == 'RM' ? 'selected' : '' }}>RM</option>
                    <option value="PNBP" {{ $pelatihan->pembiayaan == 'PNBP' ? 'selected' : '' }}>PNBP</option>
                </select>
            </div>

            <div class="mb-4">
                <x-input-label for="kelas" value="Kelas" class="text-white" />
                <x-text-input name="kelas" id="kelas" class="w-full mt-1 text-white" value="{{ old('kelas', $pelatihan->kelas) }}" />
            </div>

            <div class="mb-6">
                <x-input-label for="status" value="Status" class="text-white" />
                <select name="status" id="status" class="w-full mt-1 rounded text-black">
                    <option value="1" {{ $pelatihan->status == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ $pelatihan->status == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>

            <x-primary-button>💾 Simpan Perubahan</x-primary-button>
        </form>
    </div>
</x-admin-layout>
