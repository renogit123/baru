<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="p-6 space-y-6">
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}!</h3>
            <p class="text-gray-600">Silakan gunakan tombol berikut untuk mengelola data wilayah.</p>
            <a href="{{ route('admin.wilayah') }}"
               class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-black px-4 py-2 rounded shadow">
                Kelola Data Wilayah
            </a>
        </div>

        {{-- Kamu bisa tambahkan card/tautan lain di sini --}}
    </div>
</x-app-layout>
