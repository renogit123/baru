<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-white">
                📝 Daftar Kehadiran Peserta
            </h2>
            <a href="{{ route('admin.jadwal-pelatihan.index') }}"
               class="text-sm text-white/70 hover:underline">⬅️ Kembali</a>
        </div>
    </x-slot>

@php
    $jadwal = optional($data->first()->jadwalPelatihan ?? null);
@endphp

@if(isset($jadwal) && isset($jadwal->id))
    <div class="mb-4">
        <a href="{{ route('admin.sertifikat.download', $jadwal->id) }}"
           class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-500 text-sm">
            ⬇️ Download PDF Daftar Terima Sertifikat
        </a>
    </div>
@endif


    <div class="p-6 bg-white/5 text-white rounded shadow border border-white/10 backdrop-blur">
        @if(session('success'))
            <div class="mb-4 bg-green-600/30 border border-green-400 text-green-200 px-4 py-2 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($data->isEmpty())
            <p class="text-gray-300">Belum ada peserta yang hadir.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border border-white/20 text-sm">
                    <thead class="bg-white/10">
                        <tr>
                            <th class="px-4 py-2 border border-white/20 text-left">Nama</th>
                            <th class="px-4 py-2 border border-white/20 text-left">NIK</th>
                            <th class="px-4 py-2 border border-white/20 text-left">Judul Pelatihan</th>
                            <th class="px-4 py-2 border border-white/20 text-left">Waktu Dikonfirmasi</th>
                            <th class="px-4 py-2 border border-white/20 text-left">Status</th>
                            <th class="px-4 py-2 border border-white/20 text-left">Setujui Sertifikat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                            @php
                                $biodata = $row->user->biodata;
                            @endphp
                            <tr class="border-t border-white/10 hover:bg-white/5">
                                <td class="px-4 py-2 border border-white/10">{{ $biodata->nama ?? $row->user->name }}</td>
                                <td class="px-4 py-2 border border-white/10">{{ $biodata->nik ?? '-' }}</td>
                                <td class="px-4 py-2 border border-white/10">{{ $row->jadwalPelatihan->judul ?? '-' }}</td>
                                <td class="px-4 py-2 border border-white/10">
                                    {{ \Carbon\Carbon::parse($row->updated_at)->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB
                                </td>
                                <td class="px-4 py-2 border border-white/10">
                                    @if($biodata?->is_approved)
                                        <span class="px-2 py-1 bg-green-600 text-white rounded text-xs">Disetujui</span>
                                    @else
                                        <span class="px-2 py-1 bg-yellow-600 text-white rounded text-xs">Belum ACC</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 border border-white/10">
                                    @if(!$biodata?->is_approved)
                                    <form action="{{ route('admin.biodata.approve', $row->user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-xs px-3 py-1 bg-green-600 hover:bg-green-500 rounded text-white">
                                            ✅ Setujui
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.biodata.batal', $row->user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-xs px-3 py-1 bg-red-600 hover:bg-red-500 rounded text-white">
                                            ❌ Batalkan
                                        </button>
                                    </form>
                                @endif                                
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-admin-layout>
