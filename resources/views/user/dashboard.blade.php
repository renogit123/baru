{{-- <x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold">Dashboard User</h2>
  </x-slot>

  <div class="p-6">
    Selamat datang, {{ auth()->user()->name }} (User)
  </div>
</x-app-layout> --}}
<x-app-layout>
    <div class="max-w-3xl mx-auto p-6 bg-white shadow rounded">
        <h2 class="text-2xl font-semibold mb-4">Selamat Datang, {{ Auth::user()->name }}!</h2>
        <p class="text-gray-600 mb-6">Silakan lengkapi data biodata Anda.</p>

        <div class="flex justify-start space-x-4">
            <a href="{{ route('user.biodata.form') }}"
               class="inline-block px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Lengkapi Biodata
            </a>

            {{-- Kamu bisa tambahkan fitur lain di sini --}}
        </div>
    </div>
</x-app-layout>
