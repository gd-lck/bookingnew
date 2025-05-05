@extends('layouts.app')

@section('title', 'Layanan')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
<div x-data="{ tambahModal: false, modalId: null }" class="py-10">
    @if (session('error'))
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">{{ session('error') }}</div>
    @endif

    @if (session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    <h2 class="text-2xl font-bold text-pink-600 mb-6">Data Layanan</h2>

    <button @click="tambahModal = true" class="bg-pink-500 hover:bg-pink-600 text-white font-semibold px-4 py-2 rounded mb-6">
        Tambah Data
    </button>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white text-sm text-gray-700 border border-gray-200 rounded shadow">
            <thead class="bg-pink-100 text-pink-700">
                <tr>
                    <th class="py-2 px-4">#</th>
                    <th class="py-2 px-4">Nama Layanan</th>
                    <th class="py-2 px-4">Harga</th>
                    <th class="py-2 px-4">Durasi</th>
                    <th class="py-2 px-4">Gambar 1</th>
                    <th class="py-2 px-4">Gambar 2</th>
                    <th class="py-2 px-4">Deskripsi</th>
                    <th class="py-2 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($layanan as $item)
                <tr class="border-t">
                    <td class="py-2 px-4">{{ $loop->iteration }}</td>
                    <td class="py-2 px-4">{{ $item->nama_layanan }}</td>
                    <td class="py-2 px-4">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td class="py-2 px-4">{{ $item->durasi }} menit</td>
                    <td class="py-2 px-4">
                        <img src="{{ asset('uploads/' . $item->gambar) }}" class="w-12 h-auto rounded" alt="Gambar 1">
                    </td>
                    <td class="py-2 px-4">
                        <img src="{{ asset('uploads/' . $item->gambar2) }}" class="w-12 h-auto rounded" alt="Gambar 2">
                    </td>
                    <td class="py-2 px-4" title="{{ $item->deskripsi }}">
                        {{ Str::words($item->deskripsi, 10, '...') }}
                    </td>
                    <td class="py-2 px-4 space-x-2">
                        <button @click="modalId = {{ $item->id }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">Edit</button>
                        <form action="{{ route('layanan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus layanan ini?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">Hapus</button>
                        </form>
                    </td>
                </tr>

                <!-- Modal Update -->
                <div x-show="modalId === {{ $item->id }}" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                    <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg">
                        <h2 class="text-xl font-semibold mb-4 text-pink-600">Update Layanan</h2>
                        <form action="{{ route('layanan.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <!-- Form Fields -->
                            <div class="mb-4">
                                <label for="nama_layanan" class="block text-sm font-medium text-gray-700">Nama Layanan</label>
                                <input type="text" id="nama_layanan" name="nama_layanan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" value="{{ $item->nama_layanan }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="harga" class="block text-sm font-medium text-gray-700">Harga</label>
                                <input type="number" id="harga" name="harga" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" value="{{ $item->harga }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="durasi" class="block text-sm font-medium text-gray-700">Durasi</label>
                                <input type="number" id="durasi" name="durasi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" value="{{ $item->durasi }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                <textarea id="deskripsi" name="deskripsi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" rows="3" required>{{ $item->deskripsi }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar 1</label>
                                <input type="file" id="gambar" name="gambar" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                            </div>

                            <div class="mb-4">
                                <label for="gambar2" class="block text-sm font-medium text-gray-700">Gambar 2</label>
                                <input type="file" id="gambar2" name="gambar2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                            </div>

                            <div class="flex justify-end gap-2 mt-4">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Update</button>
                                <button type="button" @click="modalId = null" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah -->
    <div x-show="tambahModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg">
            <h2 class="text-xl font-semibold mb-4 text-pink-600">Tambah Layanan</h2>
            <form action="{{ route('layanan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Form Fields -->
                <div class="mb-4">
                    <label for="nama_layanan" class="block text-sm font-medium text-gray-700">Nama Layanan</label>
                    <input type="text" id="nama_layanan" name="nama_layanan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" required>
                </div>

                <div class="mb-4">
                    <label for="harga" class="block text-sm font-medium text-gray-700">Harga</label>
                    <input type="number" id="harga" name="harga" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" required>
                </div>

                <div class="mb-4">
                    <label for="durasi" class="block text-sm font-medium text-gray-700">Durasi</label>
                    <input type="number" id="durasi" name="durasi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" required>
                </div>

                <div class="mb-4">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" rows="3" required></textarea>
                </div>

                <div class="mb-4">
                    <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar 1</label>
                    <input type="file" id="gambar" name="gambar" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" required>
                </div>

                <div class="mb-4">
                    <label for="gambar2" class="block text-sm font-medium text-gray-700">Gambar 2</label>
                    <input type="file" id="gambar2" name="gambar2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                    <button type="button" @click="tambahModal = false" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Alpine.js -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
