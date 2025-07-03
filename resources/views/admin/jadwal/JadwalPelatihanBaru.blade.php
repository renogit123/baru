<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-yellow-300">📚 Tambah Judul Pelatihan</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto mt-6 p-6 bg-sky-950 text-white rounded-xl shadow ring-1 ring-white/10">
        {{-- Notifikasi sukses --}}
        @if(session('success'))
            <div class="mb-4 text-green-400 bg-green-900/40 px-4 py-2 rounded border border-green-600">
                {{ session('success') }}
            </div>
        @endif

        {{-- Notifikasi error --}}
        @if($errors->any())
            <div class="mb-4 text-red-400 bg-red-900/40 px-4 py-2 rounded border border-red-600">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form input --}}
        <form action="{{ route('admin.jadwal.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <x-input-label for="judul" value="Judul Pelatihan" class="text-white" />
                <x-text-input
                    id="judul"
                    name="judul"
                    type="text"
                    class="block w-full mt-1 bg-sky-900 text-white placeholder:text-gray-400 border border-white/20 rounded shadow-inner focus:ring-yellow-400 focus:border-yellow-400"
                    placeholder="Contoh: Pelatihan Digitalisasi Pemerintahan"
                    required
                />
            </div>

            <div class="pt-4">
                <x-primary-button class="bg-yellow-500 hover:bg-yellow-400 text-sky-900 font-semibold px-5 py-2 rounded shadow transition">
                    💾 Simpan
                </x-primary-button>
            </div>
        </form>
    </div>
</x-admin-layout>
