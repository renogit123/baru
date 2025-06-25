<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Portal Kemendagri</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to bottom right, #1e3a8a, #2563eb);
        }

        .card-section {
            background: linear-gradient(to bottom right, #3b82f6, #60a5fa);
        }
    </style>
</head>
<body class="min-h-screen text-white">

    <!-- Header -->
    <header class="bg-gradient-to-r from-blue-800 to-yellow-600 shadow-md">
    <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
        <div class="flex items-center space-x-3">
            <img src="{{ asset('img/Subtract.png') }}" alt="Logo" class="w-8 h-8">
            <h1 class="text-white text-xl font-semibold">Kemendagri</h1>
        </div>
        <div class="flex items-center space-x-4">
            <a href="{{ route('dashboard') }}"
               class="text-white text-sm font-medium hover:underline hover:text-yellow-300 transition">
                Dashboard
            </a>
        </div>
    </div>
</header>


    <!-- Main Content -->
    <main class="py-12 px-4">
        <div class="max-w-4xl mx-auto space-y-6">

            <!-- Update Profile Information -->
            <section class="p-6 rounded-2xl shadow-xl card-section backdrop-blur-sm">
                <h2 class="text-lg font-semibold mb-4">Informasi Profil</h2>
                <div class="max-w-2xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </section>

            <!-- Update Password -->
            <section class="p-6 rounded-2xl shadow-xl card-section backdrop-blur-sm">
                <h2 class="text-lg font-semibold mb-4">Ganti Password</h2>
                <div class="max-w-2xl">
                    @include('profile.partials.update-password-form')
                </div>
            </section>

            <!-- Delete User -->
            <section class="p-6 rounded-2xl shadow-xl card-section backdrop-blur-sm">
                <h2 class="text-lg font-semibold mb-4">Hapus Akun</h2>
                <div class="max-w-2xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </section>

        </div>
    </main>

</body>
</html>
