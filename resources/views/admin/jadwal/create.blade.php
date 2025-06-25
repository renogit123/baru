<x-admin-layout>
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold text-white">Tambah Jadwal Pelatihan</h2>
        <a href="{{ url()->previous() }}" class="text-sm px-4 py-2 bg-white/10 hover:bg-white/20 rounded text-white">
            🔙 Kembali
        </a>
    </div>

    <div class="max-w-3xl mx-auto bg-white/5 p-6 rounded shadow border border-white/10 backdrop-blur text-white">
        <form method="POST" action="{{ route('admin.jadwal-pelatihan.store') }}">
            @csrf

            <x-input-label for="judul" value="Judul Pelatihan" class="text-white/80" />
            <x-text-input name="judul" class="w-full mb-4 text-black" value="{{ old('judul') }}" />

            <x-input-label for="tgl_mulai" value="Tanggal Mulai" class="text-white/80" />
            <x-text-input name="tgl_mulai" type="date" class="w-full mb-4 text-black" value="{{ old('tgl_mulai') }}" />

            <x-input-label for="tgl_selesai" value="Tanggal Selesai" class="text-white/80" />
            <x-text-input name="tgl_selesai" type="date" class="w-full mb-4 text-black" value="{{ old('tgl_selesai') }}" />

            <x-input-label for="pembiayaan" value="Pembiayaan" class="text-white/80" />
            <select name="pembiayaan" class="w-full mb-4 text-black rounded border-gray-300">
                <option value="RM">RM</option>
                <option value="PNBP">PNBP</option>
            </select>

            <x-input-label for="kelas" value="Kelas" class="text-white/80" />
            <x-text-input name="kelas" class="w-full mb-4 text-black" value="{{ old('kelas') }}" />

            <x-input-label for="status" value="Status (Aktif?)" class="text-white/80" />
            <select name="status" class="w-full mb-6 text-black rounded border-gray-300">
                <option value="1">Aktif</option>
                <option value="0">Tidak Aktif</option>
            </select>

            <x-primary-button>✔️ Simpan</x-primary-button>
        </form>
    </div>
</x-admin-layout>
