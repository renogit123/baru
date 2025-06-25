<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-white">📷 Scan Kehadiran Peserta</h2>
            <a href="{{ route('admin.jadwal-pelatihan.index') }}"
               class="text-sm text-white/70 hover:underline">⬅️ Kembali</a>
        </div>
    </x-slot>

    <div class="p-6 bg-white/5 text-white rounded shadow border border-white/10 backdrop-blur space-y-6">
        <audio id="beep" src="https://www.soundjay.com/button/beep-07.mp3" preload="auto"></audio>

        <p class="text-white/80">Arahkan kamera ke barcode peserta atau unggah dari galeri.</p>

        {{-- Scanner Kamera --}}
        <div id="reader" class="w-full max-w-md mx-auto border border-white/20 rounded bg-black/20"></div>

        {{-- Form otomatis submit --}}
        <form id="scan-form" action="{{ route('admin.scan.proses') }}" method="POST">
            @csrf
            <input type="hidden" id="scan_result" name="scan_result">
        </form>

        {{-- Upload QR dari galeri --}}
        <div class="mt-6">
            <label class="block text-white/80 mb-1">Atau unggah gambar QR dari galeri:</label>
            <input type="file" accept="image/*" id="upload-qr" class="mb-2">
            <img id="preview" src="#" class="w-40 h-auto hidden border rounded" alt="Preview QR">
        </div>

        {{-- Scanner dari file --}}
        <div id="file-reader" class="hidden"></div>

        {{-- Tampilkan hasil scan sebelumnya --}}
        @if(session('success'))
            <div class="text-green-300 border border-green-500/30 bg-green-800/30 rounded p-3">
                ✅ {{ session('success') }}
            </div>

            @if(session('peserta'))
                @php $peserta = session('peserta'); @endphp
                <div class="mt-4 p-4 border rounded border-white/20 bg-white/5">
                    <h3 class="font-bold mb-2 text-lg text-white">Peserta Terakhir:</h3>
                    <p><strong>Nama:</strong> {{ $peserta->user->biodata->nama ?? $peserta->user->name }}</p>
                    <p><strong>NIK:</strong> {{ $peserta->user->biodata->nik ?? '-' }}</p>
                    <p><strong>Status Kehadiran:</strong> <span class="text-green-400 font-semibold">✅ Hadir</span></p>
                </div>
            @endif
        @endif
    </div>

    {{-- Script QR --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        const qrScanner = new Html5Qrcode("reader");

        Html5Qrcode.getCameras().then(cameras => {
            if (cameras && cameras.length) {
                qrScanner.start(
                    cameras[0].id,
                    { fps: 10, qrbox: 250 },
                    qrCodeMessage => {
                        document.getElementById('scan_result').value = qrCodeMessage;
                        document.getElementById('beep').play();
                        document.getElementById('scan-form').submit();
                        qrScanner.stop();
                    },
                    errorMessage => {}
                );
            }
        });

        // Scan dari file
        document.getElementById('upload-qr').addEventListener('change', function (e) {
            if (e.target.files.length === 0) return;
            const file = e.target.files[0];

            const readerPreview = new FileReader();
            readerPreview.onload = ev => {
                const img = document.getElementById('preview');
                img.src = ev.target.result;
                img.classList.remove('hidden');
            };
            readerPreview.readAsDataURL(file);

            const tempScanner = new Html5Qrcode("file-reader");
            tempScanner.scanFile(file, true)
                .then(qrCodeMessage => {
                    document.getElementById('scan_result').value = qrCodeMessage;
                    document.getElementById('beep').play();
                    document.getElementById('scan-form').submit();
                })
                .catch(err => {
                    alert("❌ Gagal membaca QR dari gambar: " + err);
                });
        });
    </script>
</x-admin-layout>
