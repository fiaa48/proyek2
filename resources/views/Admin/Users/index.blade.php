@extends('layouts.admin')

@section('content')
<!-- Sidebar -->
@include('Admin.sidebar')
<div class="ml-64 p-6">
    <h2 class="text-2xl font-bold mb-4">Data Pengguna</h2>

    <!-- Tombol Tambah Pengguna -->
    <div class="mb-4">
        <a href="{{ route('admin.users.create') }}"
           class="text-white px-4 py-2 rounded transition duration-200"
           style="background-color: #A89986;"
           onmouseover="this.style.backgroundColor='#8B8978'"
           onmouseout="this.style.backgroundColor='#A89986'">
           Tambah Pengguna
        </a>
    </div>

    <!-- Tabel -->
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full text-sm text-left border-collapse border border-gray-300">
            <thead class="uppercase text-xs" style="background-color: #EAE6DF; color: #4B453C;">
                <tr>
                    <th class="px-4 py-3 border border-gray-300">No</th>
                    <th class="px-4 py-3 border border-gray-300">Nama</th>
                    <th class="px-4 py-3 border border-gray-300">Email</th>
                    <th class="px-4 py-3 border border-gray-300">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $index => $user)
                    <tr>
                        <td class="px-4 py-2 border border-gray-300">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $user->name }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $user->email }}</td>
                        <td class="px-4 py-2 border border-gray-300">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
