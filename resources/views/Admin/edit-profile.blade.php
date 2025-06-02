@extends('layouts.admin')

@section('content')
    <div class="flex">
        @include('Admin.sidebar')


        <div class="flex-1 ml-64 container mx-auto p-6">
            <h1 class="text-2xl font-bold mb-4">Edit Profile Admin</h1>
            <form action="{{ route('admin.updateProfile') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="flex flex-col items-center mb-6">
                    <!-- Foto Profil Preview -->
                    <img id="preview-image"
                    src="{{ Auth::user()->photo
                        ? asset('storage/' . Auth::user()->photo)
                        : asset('images/default-profile.png') }}"
                    class="w-32 h-32 rounded-full object-cover mb-4 border"
                    alt="Profile Picture">

                    <!-- Upload Foto -->
                    <label for="photo"
                        class="cursor-pointer bg-gray-200 px-4 py-2 rounded-lg text-sm text-gray-700 hover:bg-gray-300">
                        Pilih Foto
                    </label>
                    <input type="file" name="photo" id="photo" class="hidden" accept="image/*"
                        onchange="previewImage(event)">
                    <p class="text-xs text-gray-500 mt-2">Ukuran disarankan: 200x200 px</p>
                </div>
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium">Nama</label>
                    <input type="text" name="name" value="{{ auth()->user()->name }}"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300"
                        required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium">Email</label>
                    <input type="email" name="email" value="{{ auth()->user()->email }}"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300"
                        required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium">Password (opsional)</label>
                    <input type="password" name="password"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300"
                        placeholder="Kosongkan jika tidak ingin mengganti password">
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300"
                        placeholder="Ulangi password baru">
                </div>
                <button type="submit"
                <button style="background-color: #A89986;" class="text-white px-4 py-2 rounded-lg w-full transition duration-200 hover:opacity-80">Simpan</button>
            </form>
        </div>
    </div>


<script>
function previewImage(event) {
    const input = event.target;
    const reader = new FileReader();
    reader.onload = function(){
        const preview = document.getElementById('preview-image');
        preview.src = reader.result;
    };
    if(input.files[0]){
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
