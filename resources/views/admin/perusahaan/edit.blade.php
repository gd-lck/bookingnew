@extends('layouts.app')

@section('title', 'Edit Perusahaan')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white rounded-xl shadow-md mt-10">
    <h2 class="text-2xl font-bold  text-pink-600 mb-6 ">Edit Informasi Perusahaan</h2>

    {{-- Notifikasi Sukses --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    {{-- Kontainer dengan flexbox --}}
    <div class="flex flex-col md:flex-row gap-8">
        {{-- Preview Logo --}}
        <div class="w-full md:w-1/3 text-center">
            <p class="font-semibold mb-2">Logo Perusahaan</p>
            <img id="logoPreview" 
                src="{{ $perusahaan->logo ? asset('storage/' . $perusahaan->logo) : 'https://via.placeholder.com/150' }}" 
                class="mx-auto h-32 w-auto object-contain border rounded" 
                alt="Preview Logo">
        </div>

        {{-- Form --}}
        <div class="w-full md:w-2/3">
            <form action="{{ route('perusahaan.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block font-semibold">Nama Perusahaan</label>
                    <input type="text" name="nama_perusahaan" value="{{ old('nama_perusahaan', $perusahaan->nama_perusahaan) }}" class="w-full border rounded p-2" required>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Telepon</label>
                    <input type="text" name="telepon" value="{{ old('telepon', $perusahaan->telepon) }}" class="w-full border rounded p-2">
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Email</label>
                    <input type="email" name="email" value="{{ old('email', $perusahaan->email) }}" class="w-full border rounded p-2">
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Alamat</label>
                    <textarea name="alamat" class="w-full border rounded p-2">{{ old('alamat', $perusahaan->alamat) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Website</label>
                    <input type="url" name="website" value="{{ old('website', $perusahaan->website) }}" class="w-full border rounded p-2">
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Upload Logo Baru</label>
                    <input type="file" name="logo" id="logoInput" class="w-full">
                </div>

                <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">Simpan</button>
            </form>
        </div>
    </div>
</div>

{{-- Script Preview Logo --}}
<script>
    document.getElementById('logoInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('logoPreview');
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
