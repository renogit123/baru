<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Scan Kehadiran</h2>
    </x-slot>

    <div class="p-6 bg-white shadow rounded">
        @if(session('success'))
            <div class="text-green-600 mb-4">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="text-red-600 mb-4">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.scan.proses') }}">
            @csrf
            <label class="block font-medium mb-2">Scan atau masukkan ID Register:</label>
            <input type="text" name="id_register" class="border rounded w-full px-3 py-2 mb-4" autofocus required>

            <x-primary-button>✔️ Simpan Kehadiran</x-primary-button>
        </form>
    </div>
</x-app-layout>
