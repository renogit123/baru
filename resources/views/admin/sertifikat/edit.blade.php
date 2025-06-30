<x-admin-layout>
    <div class="max-w-4xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-6 text-white bg-sky-900 px-4 py-2 rounded shadow">Kelola Teks Sertifikat</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4 border border-green-300">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.sertifikat.update') }}" method="POST" class="bg-sky-900 p-6 rounded-lg shadow space-y-4 border border-white/20">
            @csrf
            @method('PUT')

            <label class="block text-white font-semibold">Deskripsi Atas</label>
            <textarea name="deskripsi_atas" rows="3"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white rounded p-2">{{ old('deskripsi_atas', $text->deskripsi_atas) }}</textarea>

            <label class="block text-white font-semibold">Judul Tengah</label>
            <input type="text" name="judul_tengah"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white rounded p-2"
                value="{{ old('judul_tengah', $text->judul_tengah) }}">

            <label class="block text-white font-semibold">Deskripsi Bawah</label>
            <textarea name="deskripsi_bawah" rows="3"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white rounded p-2">{{ old('deskripsi_bawah', $text->deskripsi_bawah) }}</textarea>

            <label class="block text-white font-semibold">Nomor Sertifikat</label>
            <input type="text" name="nomor_sertifikat"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white rounded p-2"
                value="{{ old('nomor_sertifikat', $text->nomor_sertifikat) }}">

            <label class="block text-white font-semibold">Nama Penandatangan</label>
            <input type="text" name="penandatangan"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white rounded p-2"
                value="{{ old('penandatangan', $text->penandatangan) }}">

            <label class="block text-white font-semibold">Jabatan Penandatangan</label>
            <input type="text" name="jabatan_penandatangan"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white rounded p-2"
                value="{{ old('jabatan_penandatangan', $text->jabatan_penandatangan) }}">

            <label class="block text-white font-semibold">NIP Penandatangan</label>
            <input type="text" name="nip_penandatangan"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white rounded p-2"
                value="{{ old('nip_penandatangan', $text->nip_penandatangan) }}">

            <label class="block text-white font-semibold">Tanggal Sertifikat</label>
            <input type="date" name="tanggal_sertifikat"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white rounded p-2"
                value="{{ old('tanggal_sertifikat', $text->tanggal_sertifikat) }}">

            <label class="block text-white font-semibold">Kota Penetapan</label>
            <input type="text" name="kota_penetapan"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white rounded p-2"
                value="{{ old('kota_penetapan', $text->kota_penetapan) }}">

            <label class="block text-white font-semibold">Tanggal Penetapan</label>
            <input type="date" name="tanggal_penetapan"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white rounded p-2"
                value="{{ old('tanggal_penetapan', $text->tanggal_penetapan) }}">

            <label class="block text-white font-semibold">Jabatan Penetapan</label>
            <input type="text" name="jabatan_penetapan"
                class="block w-full mb-4 bg-sky-900 border border-white/20 text-white rounded p-2"
                value="{{ old('jabatan_penetapan', $text->jabatan_penetapan) }}">

            <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded transition">
                💾 Simpan
            </button>
        </form>
    </div>
</x-admin-layout>
