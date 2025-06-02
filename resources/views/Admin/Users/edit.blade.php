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
    <h2 class="text-2xl font-bold mb-4">Edit Data Pengguna</h2>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Pengguna</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full p-2 border border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="w-full p-2 border border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
            <select name="role" id="role" class="w-full p-2 border border-gray-300 rounded">
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>Customer</option>
            </select>
        </div>

        <div class="mb-4">
    <button type="submit"
        class="text-white px-4 py-2 rounded transition duration-200"
        style="background-color: #A89986;"
        onmouseover="this.style.backgroundColor='#8B8978'"
        onmouseout="this.style.backgroundColor='#A89986'">
        Update Pengguna
    </button>
</div>
    </form>
</div>
@endsection
