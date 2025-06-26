<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Tambah Judul Pelatihan</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto p-6 bg-white shadow rounded">
        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="mb-4 text-red-600">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.jadwal.store') }}" method="POST">
            @csrf
            <x-input-label for="judul" value="Judul Pelatihan" />
            <x-text-input id="judul" name="judul" type="text" class="block w-full mt-1" required />
            <x-primary-button class="mt-4">Simpan</x-primary-button>
        </form>
    </div>
</x-admin-layout>
