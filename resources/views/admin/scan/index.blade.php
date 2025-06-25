<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-white">📷 Scan Kehadiran Peserta</h2>
            <a href="{{ route('admin.jadwal-pelatihan.index') }}" class="text-sm text-white/70 hover:underline">⬅️ Kembali</a>
        </div>
    </x-slot>

    <div class="p-6 bg-white/5 text-white rounded shadow border border-white/10 backdrop-blur space-y-6">
        {{-- Notifikasi sukses --}}
        @if(session('success'))
            <div class="text-green-300 border border-green-500/30 bg-green-800/30 rounded p-3">
                ✅ {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="text-red-400 border border-red-500/30 bg-red-800/30 rounded p-3">
                ❌ {{ session('error') }}
            </div>
        @endif

        <p class="text-white/80">Arahkan kamera ke barcode peserta untuk mencatat kehadiran.</p>

        {{-- Area Scanner --}}
        <div id="reader" class="border border-white/20 rounded p-4 text-center w-full max-w-md mx-auto bg-black/20"></div>

        {{-- Form Auto Submit --}}
        <form id="absenForm" action="{{ route('admin.scan.proses') }}" method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="scan_result" id="scan_result">
        </form>
    </div>

    {{-- Script Scanner --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            console.log(`Hasil QR: ${decodedText}`);
            document.getElementById('scan_result').value = decodedText;
            document.getElementById('absenForm').submit();
        }

        const html5QrCode = new Html5Qrcode("reader");

        Html5Qrcode.getCameras().then(cameras => {
            if (cameras && cameras.length) {
                html5QrCode.start(
                    cameras[0].id,
                    { fps: 10, qrbox: { width: 250, height: 250 } },
                    onScanSuccess
                );
            }
        }).catch(err => {
            console.error("Tidak bisa mengakses kamera: ", err);
            document.getElementById("reader").innerHTML =
                "<p class='text-red-500'>❌ Tidak dapat mengakses kamera. Pastikan izin kamera diaktifkan.</p>";
        });
    </script>
</x-admin-layout>
