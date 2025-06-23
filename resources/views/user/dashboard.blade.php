<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold">Dashboard User</h2>
  </x-slot>

  <div class="p-6">
    Selamat datang, {{ auth()->user()->name }} (User)
  </div>
</x-app-layout>
