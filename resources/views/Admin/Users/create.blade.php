@extends('layouts.admin')

@section('content')
<aside style="background-color: #A89986;" class="h-screen w-64 text-black p-5 space-y-6 fixed">
    <h2 class="text-2xl font-bold">TechFix Admin</h2>
    <nav>
        <a href="{{ route('admin.dashboard') }}" class="block py-2 px-4 hover:bg-gray-700 rounded">Dashboard</a>
        <a href="{{ route('admin.orders') }}" class="block py-2 px-4 hover:bg-gray-700 rounded">Data Pesanan</a>
        <a href="{{ route('admin.catalog') }}" class="block py-2 px-4 hover:bg-gray-700 rounded">Data Katalog</a>
        <a href="{{ route('admin.users') }}" class="block py-2 px-4 hover:bg-gray-700 rounded">Data Pengguna</a>
        {{-- <a href="{{ route('admin.pembayaran') }}" class="block py-2 px-4 hover:bg-gray-700 rounded">Pembayaran</a> --}}
    </nav>
</aside>
<div class="p-6 pl-64 ml-4">
    <h2 class="text-2xl font-bold mb-4">Tambah Pengguna</h2>

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700">Nama</label>
            <input type="text" name="name" id="name" class="border border-gray-300 p-2 rounded w-full" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input type="email" name="email" id="email" class="border border-gray-300 p-2 rounded w-full" required>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-gray-700">Password</label>
            <input type="password" name="password" id="password" class="border border-gray-300 p-2 rounded w-full" required>
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block text-gray-700">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="border border-gray-300 p-2 rounded w-full" required>
        </div>

        <button type="submit"
    class="text-white px-4 py-2 rounded transition duration-200"
    style="background-color: #A89986;"
    onmouseover="this.style.backgroundColor='#8B8978'"
    onmouseout="this.style.backgroundColor='#A89986'">
    Simpan
</button>
    </form>
</div>
@endsection
