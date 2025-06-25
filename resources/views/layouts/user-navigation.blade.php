<nav class="bg-gradient-to-r from-blue-800 to-yellow-600 text-white shadow-2xl backdrop-blur-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
        {{-- Logo dan Teks --}}
        <div class="flex items-center space-x-2">
            <img src="{{ asset('img/Subtract.png') }}" alt="Kemendagri Logo" class="h-9 w-9 drop-shadow-lg">
            <span class="font-extrabold text-2xl bg-gradient-to-r from-yellow-300 via-white to-yellow-100 bg-clip-text text-transparent tracking-wider drop-shadow-xl">
                KEMENDAGRI
            </span>
        </div>

        {{-- Profil Dropdown --}}
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open"
                class="inline-flex items-center px-4 py-2 text-sm font-semibold rounded-md hover:bg-white/10 transition backdrop-blur-lg shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5.121 17.804A9.004 9.004 0 0112 15a9.004 9.004 0 016.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>{{ Auth::user()->name }}</span>
                <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            {{-- Dropdown menu --}}
            <div x-show="open" @click.away="open = false"
                 class="absolute right-0 mt-2 w-48 bg-white text-gray-800 rounded-lg shadow-2xl z-50 py-1">
                <a href="{{ route('profile.edit') }}"
                   class="block px-4 py-2 hover:bg-gray-100">Profil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full text-left px-4 py-2 hover:bg-gray-100">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
