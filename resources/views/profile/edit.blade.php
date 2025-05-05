@extends('layouts.app')

@section('content')

<div class="container mx-auto mt-10 py-20">
        @if(session('success'))
            <div class="mt-4 p-3 bg-green-100 text-green-700 rounded-md text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mt-4 p-3 bg-red-100 text-red-700 rounded-md text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    <div class="flex justify-center">
        <!-- Profil User -->
        <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-center mb-4">Profil Saya</h2>

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <!-- Nama -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-pink-500 focus:border-pink-500">
                        @error('name')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Telepon -->
                    <div>
                        <label for="telepon" class="block text-sm font-medium text-gray-700">Telepon</label>
                        <input type="text" name="telepon" id="telepon" value="{{ old('telepon', $user->telepon) }}"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-pink-500 focus:border-pink-500">
                        @error('telepon')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                        <input type="text" name="alamat" id="alamat" value="{{ old('alamat', $user->alamat) }}"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-pink-500 focus:border-pink-500">
                        @error('alamat')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-center mt-4">
                        <button type="submit" class="px-6 py-2 text-white bg-pink-500 hover:bg-pink-600 rounded-md">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>

           <!-- Modal Edit Password -->
            <div class="mt-6 text-center">
                <div x-data="{ openPasswordModal: false }">
                    <button @click="openPasswordModal = true" class="text-sm text-pink-500 hover:text-pink-600">
                        Ubah Password
                    </button>

                    <!-- Modal -->
                    <div x-show="openPasswordModal" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50"
                        x-cloak x-transition>
                        <div class="bg-white p-6 rounded-lg shadow-lg w-96 relative">
                            <h2 class="text-2xl font-semibold text-center mb-4">Ubah Password</h2>
                            <form action="{{ route('profile.updatePassword') }}" method="POST">
                                @csrf
                                <div class="space-y-4">
                                    <!-- Password Lama -->
                                    <div>
                                        <label for="current_password" class="block text-sm font-medium text-gray-700">Password Lama</label>
                                        <input type="password" name="current_password" id="current_password" required
                                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-pink-500 focus:border-pink-500">
                                        @error('current_password')
                                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Password Baru -->
                                    <div>
                                        <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                                        <input type="password" name="password" id="password" required
                                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-pink-500 focus:border-pink-500">
                                        @error('password')
                                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Konfirmasi Password -->
                                    <div>
                                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" required
                                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-pink-500 focus:border-pink-500">
                                    </div>

                                    <div class="flex justify-center mt-4">
                                        <button type="submit" class="px-6 py-2 text-white bg-pink-500 hover:bg-pink-600 rounded-md">
                                            Simpan Password Baru
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <button @click="openPasswordModal = false" class="absolute top-0 right-0 p-2 text-gray-500 hover:text-gray-700">
                                &times;
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection


