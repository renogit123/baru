<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="p-6 space-y-6">
        {{-- Kartu Selamat Datang --}}
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}!</h3>
            <p class="text-gray-600">Silakan gunakan tombol berikut untuk mengelola data wilayah dan biodata pengguna.</p>

            {{-- Tombol Kelola Wilayah --}}
            <a href="{{ route('admin.wilayah') }}"
               class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                Kelola Data Wilayah
            </a>

            {{-- Tombol Kelola Biodata User --}}
            <a href="{{ route('admin.user.biodata.index') }}"
               class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                Kelola Biodata User
            </a>

            {{-- Tombol Kelola Jadwal Pelatihan --}}
            <a href="{{ route('admin.jadwal-pelatihan.index') }}"
               class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                Kelola Jadwal Pelatihan
            </a>

            {{-- ✅ Tombol Scan Kehadiran --}}
            <a href="{{ route('admin.scan') }}"
            class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
            Scan Kehadiran
            </a>

            <a href="{{ route('admin.kehadiran') }}"
            class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
            Lihat Kehadiran Peserta
</a>

        </div>
    </div>
</x-app-layout>
