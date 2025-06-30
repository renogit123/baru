<!-- layouts/admin-sidebar.blade.php -->
<nav class="w-full sm:w-64 min-h-screen bg-gray-900 text-gray-100 shadow-md flex flex-col justify-between">
    <!-- Atas: Logo dan Menu -->
    <div class="px-6 py-4">
        <!-- Logo -->
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 mb-6">
            <img src="{{ asset('img/Subtract.png') }}" alt="Kemendagri Logo" class="h-8 w-8">
            <span class="text-lg font-bold bg-gradient-to-r from-yellow-300 to-white bg-clip-text text-transparent">
                Admin Kemendagri
            </span>
        </a>

        <!-- Menu Items -->
        <ul class="space-y-2 text-sm">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="block px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}">
                    🏠 Dashboard
                </a>
            </li>

            <!-- Dropdown Wilayah -->
            <li x-data="{ open: false }">
                <button @click="open = !open" class="w-full flex justify-between items-center px-3 py-2 rounded hover:bg-gray-700 focus:outline-none">
                    🗺️ Wilayah
                    <svg :class="{ 'rotate-180': open }" class="h-4 w-4 transition-transform" fill="none" stroke="currentColor">
                        <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <ul x-show="open" x-transition class="pl-4 mt-1 space-y-1">
                    <li><a href="{{ route('admin.provinsi.index') }}" class="block px-2 py-1 hover:bg-gray-700 rounded">Tambah Provinsi</a></li>
                    <li><a href="{{ route('admin.kabupaten-kota.index') }}" class="block px-2 py-1 hover:bg-gray-700 rounded">Tambah Kabupaten</a></li>
                    <li><a href="{{ route('admin.kecamatan.index') }}" class="block px-2 py-1 hover:bg-gray-700 rounded">Tambah Kecamatan</a></li>
                    <li><a href="{{ route('admin.kelurahan.index') }}" class="block px-2 py-1 hover:bg-gray-700 rounded">Tambah Kelurahan</a></li>
                    <li><hr class="border-gray-700 my-1"></li>
                    <li><a href="{{ route('admin.wilayah') }}" class="block px-2 py-1 hover:bg-gray-700 rounded">Lihat Wilayah</a></li>
                </ul>
            </li>

            <!-- Biodata -->
            <li>
                <a href="{{ route('admin.user.biodata.index') }}" class="block px-3 py-2 hover:bg-gray-700 rounded">
                    🧑‍💼 Biodata
                </a>
            </li>

            <!-- Pelatihan -->
            <li x-data="{ open: false }">
                <button @click="open = !open" class="w-full flex justify-between items-center px-3 py-2 rounded hover:bg-gray-700 focus:outline-none">
                    📝 Pelatihan
                    <svg :class="{ 'rotate-180': open }" class="h-4 w-4 transition-transform" fill="none" stroke="currentColor">
                        <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <ul x-show="open" x-transition class="pl-4 mt-1 space-y-1">
                    <li><a href="{{ route('admin.jadwal-pelatihan.index') }}" class="block px-2 py-1 hover:bg-gray-700 rounded">Buat Pelatihan</a></li>
                    
                    {{-- ✅ Tambah Judul Pelatihan Baru --}}
                    <li><a href="{{ route('admin.jadwal.JadwalPelatihanBaru') }}" class="block px-2 py-1 hover:bg-gray-700 rounded">Tambah Judul Pelatihan</a></li>
            
                    <li><a href="{{ route('admin.scan') }}" class="block px-2 py-1 hover:bg-gray-700 rounded">Scan Kehadiran</a></li>
                    <li><a href="{{ route('admin.kehadiran') }}" class="block px-2 py-1 hover:bg-gray-700 rounded">Lihat Kehadiran</a></li>
                </ul>
            </li>

            <li>
                <a href="{{ route('admin.sertifikat.edit') }}" class="block px-3 py-2 hover:bg-gray-700 rounded">
                    📄 Kelola Sertifikat
                </a>
            </li>
            
        </div>

        

    <!-- Bawah: Profile -->
    <div class="px-6 py-4 border-t border-gray-700">
        <div class="text-xs text-gray-400 mb-1">👤 {{ Auth::user()->name }}</div>
        <a href="{{ route('profile.edit') }}" class="block px-3 py-1 hover:bg-gray-700 rounded">⚙️ Profil</a>
        <form method="POST" action="{{ route('logout') }}" class="mt-1">
            @csrf
            <button type="submit" class="w-full text-left px-3 py-1 hover:bg-gray-700 rounded">🚪 Keluar</button>
        </form>
    </div>

</nav>
