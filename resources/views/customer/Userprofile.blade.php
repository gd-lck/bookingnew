@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div x-data="{ editModal: false }" class="py-20 px-4 max-w-3xl mx-auto">
    @if (session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-pink-600">Profil Saya</h2>
            <button @click="editModal = true"
                class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded">
                Edit Profil
            </button>
        </div>

        <div class="grid gap-4 text-sm text-gray-700">
            <div>
                <span class="font-semibold">Nama:</span> {{ Auth::user()->name }}
            </div>
            <div>
                <span class="font-semibold">Email:</span> {{ Auth::user()->email }}
            </div>
            <div>
                <span class="font-semibold">Telepon:</span> {{ Auth::user()->telepon ?? '-' }}
            </div>
            <div>
                <span class="font-semibold">Alamat:</span> {{ Auth::user()->alamat ?? '-' }}
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div x-show="editModal" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
            <button @click="editModal = false" class="absolute top-2 right-2 text-gray-500 hover:text-red-600 text-xl">&times;</button>
            <h3 class="text-lg font-semibold text-pink-600 mb-4">Edit Profil</h3>

            <form method="POST" action="{{ route('profile.update', Auth::user()->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm mb-1">Nama</label>
                    <input type="text" name="name" value="{{ Auth::user()->name }}" class="w-full border px-3 py-2 rounded" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm mb-1">Email</label>
                    <input type="email" name="email" value="{{ Auth::user()->email }}" class="w-full border px-3 py-2 rounded" readonly required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm mb-1">Telepon</label>
                    <input type="text" name="telepon" value="{{ Auth::user()->telepon }}" class="w-full border px-3 py-2 rounded">
                </div>

                <div class="mb-4">
                    <label class="block text-sm mb-1">Alamat</label>
                    <input type="text" name="alamat" value="{{ Auth::user()->alamat }}" class="w-full border px-3 py-2 rounded">
                </div>

                <div class="text-right">
                    <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
