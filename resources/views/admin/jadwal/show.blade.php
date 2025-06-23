<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Detail Jadwal: {{ $jadwal->judul }}</h2>
    </x-slot>

    <div class="p-6 bg-white shadow rounded space-y-6">
        <div>
            <h3 class="text-lg font-bold">Informasi Pelatihan</h3>
            <p><strong>Tanggal:</strong> {{ $jadwal->tgl_mulai }} s/d {{ $jadwal->tgl_selesai }}</p>
            <p><strong>Status:</strong>
                @if($jadwal->status)
                    <span class="text-green-600 font-semibold">Aktif</span>
                @else
                    <span class="text-gray-600 font-semibold">Tidak Aktif</span>
                @endif
            </p>
        </div>

        <div>
            <h3 class="text-lg font-bold">Daftar Peserta</h3>

            @if(session('success'))
                <div class="text-green-600">{{ session('success') }}</div>
            @endif

            <table class="min-w-full border divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">Nama</th>
                        <th class="px-4 py-2">NIK</th>
                        <th class="px-4 py-2">Status Pendaftaran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jadwal->pendaftars as $pendaftar)
                        <tr class="border-t">
                            <td class="px-4 py-2">
                                {{ $pendaftar->user->biodata->nama ?? $pendaftar->user->name }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $pendaftar->user->biodata->nik ?? '-' }}
                            </td>
                            <td class="px-4 py-2">
                                @if($pendaftar->status_peserta === 'approved')
                                    <span class="text-green-600 font-semibold">✅ Disetujui</span>
                                @else
                                    <form method="POST" action="{{ route('admin.pelatihan.acc', $pendaftar->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <button 
                                            class="text-green-600 hover:underline"
                                            onclick="this.disabled=true; this.innerText='Menyetujui...'; this.form.submit();">
                                            ✅ ACC
                                        </button>
                                    </form>
                                @endif
                            </td>
                            
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-gray-500 py-4">Belum ada peserta.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
