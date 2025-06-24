<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Scan Kehadiran Peserta
        </h2>
    </x-slot>

    <div class="p-6 bg-white rounded shadow">
        <p class="text-gray-600 mb-4">Arahkan kamera ke barcode peserta untuk mencatat kehadiran.</p>

        <div id="reader" class="border border-gray-300 rounded p-4 text-center"></div>

        <form id="absenForm" action="{{ route('admin.scan.proses') }}" method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="scan_result" id="scan_result">
        </form>
    </div>

    {{-- Script Scanner --}}
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            console.log(`Hasil QR: ${decodedText}`);
            document.getElementById('scan_result').value = decodedText;
            document.getElementById('absenForm').submit();
        }

        let html5QrCode = new Html5Qrcode("reader");

        Html5Qrcode.getCameras().then(cameras => {
            if (cameras && cameras.length) {
                html5QrCode.start(
                    cameras[0].id,
                    {
                        fps: 10,
                        qrbox: { width: 250, height: 250 }
                    },
                    onScanSuccess
                );
            }
        }).catch(err => {
            console.error("Tidak bisa mengakses kamera: ", err);
            document.getElementById("reader").innerHTML = "<p class='text-red-500'>Gagal mengakses kamera.</p>";
        });
    </script>
</x-app-layout>
