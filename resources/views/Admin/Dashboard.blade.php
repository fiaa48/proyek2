<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - TechFix</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#A89986',
                        secondary: '#EAE6DF',
                        accent: '#8B7D6B',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        .notification-item:hover {
            background-color: #f5f5f5;
        }
        .dashboard-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-gray-50 font-sans" x-data="{ openDropdown: false, openEditProfile: false, showNotif: false }">
    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('Admin.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Navbar -->
            <header class="bg-primary shadow-sm py-3 px-6 flex justify-between items-center">
                <h1 class="text-xl font-semibold text-white hidden md:block">Admin Dashboard</h1>

                <div class="flex items-center space-x-6 ml-auto">
                    <!-- Notifikasi -->
                    <div class="relative">
                        @php
                            $customerNotifications = $notifications->where('target_role', 'admin');
                            $unreadCount = $customerNotifications->where('is_read', false)->count();
                            $sortedNotifications = $customerNotifications->sortByDesc('created_at');
                        @endphp

                        <button @click="showNotif = !showNotif" class="relative p-1 rounded-full hover:bg-accent hover:bg-opacity-20 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            @if ($unreadCount > 0)
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </button>

                        <div x-show="showNotif" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95" @click.away="showNotif = false"
                            class="absolute right-0 mt-2 w-80 bg-white shadow-lg rounded-lg p-0 z-50 divide-y divide-gray-100">
                            <div class="px-4 py-3 border-b">
                                <p class="font-bold text-gray-800">Notifikasi</p>
                                @if ($unreadCount > 0)
                                    <form action="{{ route('notifications.readAll') }}" method="POST" class="mt-1">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-xs text-blue-500 hover:text-blue-700">Tandai Semua Sudah Dibaca</button>
                                    </form>
                                @endif
                            </div>

                            <div class="notifications max-h-96 overflow-y-auto">
                                @forelse ($sortedNotifications as $notif)
                                    <div class="notification-item px-4 py-3 hover:bg-gray-50 transition {{ $notif->is_read ? 'bg-white' : 'bg-blue-50' }}">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <strong class="text-sm font-medium {{ $notif->is_read ? 'text-gray-700' : 'text-blue-600' }}">{{ $notif->title }}</strong>
                                                <p class="text-xs text-gray-600 mt-1">{{ $notif->message }}</p>
                                            </div>
                                            @if (!$notif->is_read)
                                                <form action="{{ route('notifications.read', $notif->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-xs text-blue-500 hover:text-blue-700">Tandai</button>
                                                </form>
                                            @endif
                                        </div>
                                        <small class="text-xs text-gray-500 block mt-2">{{ $notif->created_at->diffForHumans() }}</small>
                                    </div>
                                @empty
                                    <div class="px-4 py-6 text-center">
                                        <p class="text-sm text-gray-500">Tidak ada notifikasi.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Dropdown Profile -->
                    <div class="relative">
                        <button @click="openDropdown = !openDropdown" class="flex items-center space-x-2 focus:outline-none">
                            <div class="w-9 h-9 rounded-full bg-white flex items-center justify-center overflow-hidden border-2 border-white shadow">
                                <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&color=7F9CF5&background=EBF4FF' }}"
                                    alt="Avatar" class="w-full h-full object-cover">
                            </div>
                            <span class="text-white font-medium hidden md:inline">{{ Auth::user()->name }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white hidden md:inline" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="openDropdown" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95" @click.away="openDropdown = false"
                            class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-lg overflow-hidden z-50">
                            <div class="px-4 py-3 border-b">
                                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <a href="{{ route('admin.editProfile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Edit Profil
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 transition flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <main class="flex-1 overflow-y-auto p-6">
                <div class="max-w-7xl mx-auto">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Dashboard Admin</h2>
                        <p class="text-sm text-gray-500">Terakhir diperbarui: {{ now()->format('d M Y, H:i') }}</p>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                        <div class="dashboard-card bg-white p-5 rounded-xl shadow-sm border-l-4 border-primary transition duration-300 ease-in-out">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Pesanan</h3>
                                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $total }}</p>
                                </div>
                                <div class="p-3 rounded-full bg-primary bg-opacity-10 text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Semua pesanan yang masuk</p>
                        </div>

                        <div class="dashboard-card bg-white p-5 rounded-xl shadow-sm border-l-4 border-green-500 transition duration-300 ease-in-out">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Selesai</h3>
                                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $completed }}</p>
                                </div>
                                <div class="p-3 rounded-full bg-green-500 bg-opacity-10 text-green-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Pesanan yang sudah selesai</p>
                        </div>

                        <div class="dashboard-card bg-white p-5 rounded-xl shadow-sm border-l-4 border-yellow-500 transition duration-300 ease-in-out">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Menunggu Konfirmasi</h3>
                                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $pending }}</p>
                                </div>
                                <div class="p-3 rounded-full bg-yellow-500 bg-opacity-10 text-yellow-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Pesanan yang perlu dikonfirmasi</p>
                        </div>

                        <div class="dashboard-card bg-white p-5 rounded-xl shadow-sm border-l-4 border-red-500 transition duration-300 ease-in-out">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Ditolak</h3>
                                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $rejected }}</p>
                                </div>
                                <div class="p-3 rounded-full bg-red-500 bg-opacity-10 text-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Pesanan yang ditolak</p>
                        </div>
                    </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
