<x-admin-layout>
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold text-white">Edit Jadwal Pelatihan</h2>
        <a href="{{ route('admin.jadwal-pelatihan.index') }}" class="text-sm px-4 py-2 bg-white/10 hover:bg-white/20 rounded text-white">
            🔙 Kembali
        </a>
    </div>

    <div class="max-w-3xl mx-auto bg-white/5 p-6 rounded shadow border border-white/10 backdrop-blur text-white">
        <form method="POST" action="{{ route('admin.jadwal-pelatihan.update', $pelatihan->id) }}">
            @csrf
            @method('PUT')

            <x-input-label for="judul" value="Judul Pelatihan" class="text-white/80" />
            <select name="judul" class="w-full mb-4 text-black rounded border-gray-300" required>
                <option value="">-- Pilih Judul Pelatihan --</option>
                @foreach ($judulList as $judul)
                    <option value="{{ $judul->judul }}" {{ $pelatihan->judul == $judul->judul ? 'selected' : '' }}>
                        {{ $judul->judul }}
                    </option>
                @endforeach
            </select>

            <x-input-label for="provinsi_id" value="Provinsi" class="text-white/80" />
            <select id="provinsi" name="provinsi_id" class="w-full mb-4 text-black rounded border-gray-300" required>
                <option value="">-- Pilih Provinsi --</option>
                @foreach($provinsis as $provinsi)
                    <option value="{{ $provinsi->id }}" {{ $pelatihan->provinsi_id == $provinsi->id ? 'selected' : '' }}>
                        {{ $provinsi->nama }}
                    </option>
                @endforeach
            </select>

            <x-input-label for="kabupaten_id" value="Kabupaten" class="text-white/80" />
            <select id="kabupaten" name="kabupaten_id" class="w-full mb-4 text-black rounded border-gray-300" required>
                <option value="">-- Pilih Kabupaten --</option>
                {{-- Diisi via JS --}}
            </select>

            <x-input-label for="tgl_mulai" value="Tanggal Mulai" class="text-white/80" />
            <x-text-input name="tgl_mulai" type="date" class="w-full mb-4 text-black"
                value="{{ old('tgl_mulai', $pelatihan->tgl_mulai) }}" />

            <x-input-label for="tgl_selesai" value="Tanggal Selesai" class="text-white/80" />
            <x-text-input name="tgl_selesai" type="date" class="w-full mb-4 text-black"
                value="{{ old('tgl_selesai', $pelatihan->tgl_selesai) }}" />

            <x-text-input name="jam_mulai" type="time" class="w-full mb-4 text-black"
                value="{{ old('jam_mulai', substr($pelatihan->jam_mulai, 0, 5)) }}" />

            <x-text-input name="jam_selesai" type="time" class="w-full mb-4 text-black"
                value="{{ old('jam_selesai', substr($pelatihan->jam_selesai, 0, 5)) }}" />


            <x-input-label for="pembiayaan" value="Pembiayaan" class="text-white/80" />
            <select name="pembiayaan" class="w-full mb-4 text-black rounded border-gray-300">
                <option value="RM" {{ $pelatihan->pembiayaan == 'RM' ? 'selected' : '' }}>RM</option>
                <option value="PNBP" {{ $pelatihan->pembiayaan == 'PNBP' ? 'selected' : '' }}>PNBP</option>
            </select>

            <x-input-label for="kelas" value="Kelas" class="text-white/80" />
            <x-text-input name="kelas" class="w-full mb-4 text-black"
                value="{{ old('kelas', $pelatihan->kelas) }}" />

            <x-input-label for="status" value="Status (Aktif?)" class="text-white/80" />
            <select name="status" class="w-full mb-6 text-black rounded border-gray-300">
                <option value="1" {{ $pelatihan->status ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ !$pelatihan->status ? 'selected' : '' }}>Tidak Aktif</option>
            </select>

            <x-primary-button>💾 Update</x-primary-button>
        </form>
    </div>

    <script>
        const wilayah = @json($provinsis);
        const selectedKabupatenId = {{ $pelatihan->kabupaten_id ?? 'null' }};
        const selectedProvId = {{ $pelatihan->provinsi_id ?? 'null' }};

        function populateKabupaten(provId) {
            const kabSelect = document.getElementById('kabupaten');
            kabSelect.innerHTML = '<option value="">-- Pilih Kabupaten --</option>';

            const selected = wilayah.find(p => p.id == provId);
            if (selected && selected.kabupaten_kotas) {
                selected.kabupaten_kotas.forEach(kab => {
                    const opt = document.createElement('option');
                    opt.value = kab.id;
                    opt.text = kab.nama;
                    if (kab.id == selectedKabupatenId) {
                        opt.selected = true;
                    }
                    kabSelect.appendChild(opt);
                });
            }
        }

        document.getElementById('provinsi').addEventListener('change', function () {
            populateKabupaten(this.value);
        });

        if (selectedProvId) {
            populateKabupaten(selectedProvId);
        }
    </script>
</x-admin-layout>
