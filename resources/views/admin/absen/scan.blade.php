<x-admin-layout>
    <h2 class="text-xl font-semibold text-white mb-6">Scan Kehadiran</h2>

    <div class="p-6 bg-white/5 rounded shadow border border-white/10 backdrop-blur text-white max-w-xl mx-auto">
        @if(session('success'))
            <div class="text-green-400 mb-4">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="text-red-400 mb-4">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.scan.proses') }}">
            @csrf
            <label class="block font-medium mb-2 text-white/80">Scan atau masukkan ID Register:</label>
            <input
                type="text"
                name="id_register"
                class="w-full px-4 py-2 mb-4 rounded border text-black"
                autofocus
                required
            >

            <x-primary-button>✔️ Simpan Kehadiran</x-primary-button>
        </form>
    </div>
</x-admin-layout>
