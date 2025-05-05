@extends('layouts.app')

@section('title', 'Karyawan')

@section('content')
<!-- Tambahkan x-data di container utama -->
<div x-data="modalHandler" class="py-10">
    <h2 class="text-2xl font-bold text-pink-600 mb-6">Data Karyawan</h2>

    <button @click="tambahModal = true" class="bg-pink-500 hover:bg-pink-600 text-white font-semibold px-4 py-2 rounded mb-6">
        Tambah Data
    </button>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white text-sm text-gray-700 border border-gray-200 rounded shadow">
            <thead class="bg-pink-100 text-pink-700">
                <tr>
                    <th class="py-2 px-4 text-left">#</th>
                    <th class="py-2 px-4 text-left">Nama</th>
                    <th class="py-2 px-4 text-left">Email</th>
                    <th class="py-2 px-4 text-left">Status Kerja</th>
                    <th class="py-2 px-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($karyawan as $item)
                <tr class="border-t">
                    <td class="py-2 px-4">{{ $loop->iteration }}</td>
                    <td class="py-2 px-4">{{ $item->nama }}</td>
                    <td class="py-2 px-4">{{ $item->email }}</td>
                    <td class="py-2 px-4">{{ $item->status_kerja }}</td>
                    <td class="py-2 px-4 space-x-2">
                        <button 
                            @click="openEditModal({{ $item }})" 
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                            edit
                        </button>
                        <form action="{{ route('karyawan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus karyawan ini?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Floating Modal Tambah -->
    <div x-show="tambahModal" x-transition class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
        <div @click.away="tambahModal = false" class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg">
            <h2 class="text-xl font-semibold mb-4 text-pink-600">Tambah Data Karyawan</h2>
            <form action="{{ route('karyawan.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Nama</label>
                    <input type="text" name="nama" class="w-full border px-3 py-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email" class="w-full border px-3 py-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Status Kerja</label>
                    <select name="status_kerja" class="w-full border px-3 py-2 rounded">
                        <option value="Tersedia">Tersedia</option>
                        <option value="Tidak Tersedia">Tidak Tersedia</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                    <button type="button" @click="tambahModal = false" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Floating Modal Edit -->
    <div x-show="editModal" x-transition class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
        <div @click.away="editModal = false" class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg">
            <h2 class="text-xl font-semibold mb-4 text-pink-600">Edit Data Karyawan</h2>
            <form :action="`/karyawan/${editData.id}`" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Nama</label>
                    <input type="text" name="nama" x-model="editData.nama" class="w-full border px-3 py-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email" x-model="editData.email" class="w-full border px-3 py-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Status Kerja</label>
                    <select name="status_kerja" x-model="editData.status_kerja" class="w-full border px-3 py-2 rounded">
                        <option value="Tersedia">Tersedia</option>
                        <option value="Tidak Tersedia">Tidak Tersedia</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Update</button>
                    <button type="button" @click="editModal = false" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Alpine.js -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('modalHandler', () => ({
    tambahModal: false,
    editModal: false,
    editData: {
        id: null,
        nama: '',
        email: '',
        status_kerja: '',
    },
    openEditModal(data) {
        this.editData = { ...data };
        this.editModal = true;
    }
}));

    });
</script>
@endsection
