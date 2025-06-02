<aside class="h-screen w-64 bg-[#A89986] text-black p-5 space-y-6 fixed">
    <h2 class="text-2xl font-bold">TechFix Admin</h2>
    <nav class="space-y-2">
        <a href="{{ route('admin.dashboard') }}" 
           class="block py-2 px-4 rounded transition-colors duration-200 
                  @if(Route::is('admin.dashboard')) bg-gray-800 text-white @else hover:bg-gray-700 hover:text-white @endif">
           Dashboard
        </a>
        <a href="{{ route('admin.orders') }}" 
           class="block py-2 px-4 rounded transition-colors duration-200 
                  @if(Route::is('admin.orders')) bg-gray-800 text-white @else hover:bg-gray-700 hover:text-white @endif">
           Data Pesanan
        </a>
        <a href="{{ route('admin.catalog') }}" 
           class="block py-2 px-4 rounded transition-colors duration-200 
                  @if(Route::is('admin.catalog')) bg-gray-800 text-white @else hover:bg-gray-700 hover:text-white @endif">
           Data Katalog
        </a>
        <a href="{{ route('admin.users') }}" 
           class="block py-2 px-4 rounded transition-colors duration-200 
                  @if(Route::is('admin.users')) bg-gray-800 text-white @else hover:bg-gray-700 hover:text-white @endif">
           Data Pengguna
        </a>
        <a href="{{ route('admin.reports') }}" 
           class="block py-2 px-4 rounded transition-colors duration-200 
                  @if(Route::is('admin.reports')) bg-gray-800 text-white @else hover:bg-gray-700 hover:text-white @endif">
           Laporan
        </a>
    </nav>
</aside>