@extends('layouts.app')

@section('title', 'Daftar User')

@section('content')

@if (session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

<div x-data="{ showModal: false, showAddModal: false, selectedUser: null}" class="py-10">
    <h2 class="text-2xl font-bold text-pink-600 mb-6">Data User</h2>

    <div class="mb-4">
        <button @click="showAddModal = true" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
            + Tambah Admin
        </button>
    </div>

    <!-- Search and Filter -->
    <div class="flex justify-between items-center mb-4">
        <form method="GET" action="" class="flex items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari user..." class="border px-3 py-2 rounded w-64">
            <select name="role" onchange="this.form.submit()" class="border px-3 py-2 rounded">
                <option value="">Semua</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>customer</option>
            </select>
            <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white px-3 py-2 rounded">Cari</button>
        </form>
    </div>

    <!-- Tabel User -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white text-sm text-gray-700 border border-gray-200 rounded shadow">
            <thead class="bg-pink-100 text-pink-700">
                <tr>
                    <th class="py-2 px-4 text-left">#</th>
                    <th class="py-2 px-4 text-left">Nama</th>
                    <th class="py-2 px-4 text-left">Email</th>
                    <th class="py-2 px-4 text-left">Telepon</th>
                    <th class="py-2 px-4 text-left">Alamat</th>
                    <th class="py-2 px-4 text-left">Role</th>
                    <th class="py-2 px-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                <tr class="border-t">
                    <td class="py-2 px-4">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                    <td class="py-2 px-4">{{ $user->name }}</td>
                    <td class="py-2 px-4">{{ $user->email }}</td>
                    <td class="py-2 px-4">{{ $user->telepon }}</td>
                    <td class="py-2 px-4">{{ $user->alamat }}</td>
                    <td class="py-2 px-4">{{ $user->getRoleNames()->first() }}</td>
                    <td class="py-2 px-4 space-x-2">

                        <a href="javascript:void(0)" 
                            @click="showModal = true; selectedUser = {{ $user }}" 
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                            Edit
                        </a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-4 text-center text-gray-500">Tidak ada data user.</td>
                </tr>
                @endforelse
            </tbody>
        </table>    
    </div>

    <!-- Modal Tambah User -->
    <div x-show="showAddModal" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
            <button @click="showAddModal = false" class="absolute top-2 right-2 text-gray-500 hover:text-red-600 text-xl">&times;</button>
            <h3 class="text-lg font-semibold text-green-600 mb-4">Tambah User</h3>
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm mb-1">Nama</label>
                    <input type="text" name="name" class="w-full border px-3 py-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm mb-1">Email</label>
                    <input type="email" name="email" class="w-full border px-3 py-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm mb-1">Telepon</label>
                    <input type="text" name="telepon" class="w-full border px-3 py-2 rounded">
                </div>
                <div class="mb-4">
                    <label class="block text-sm mb-1">Alamat</label>
                    <input type="text" name="alamat" class="w-full border px-3 py-2 rounded">
                </div>
                <div class="mb-4">
                    <label class="block text-sm mb-1">Password</label>
                    <input type="password" name="password" class="w-full border px-3 py-2 rounded" required>
                </div>
                <div class="text-right">
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Modal Edit -->
    <div x-show="showModal" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
            <button @click="showModal = false" class="absolute top-2 right-2 text-gray-500 hover:text-red-600 text-xl">&times;</button>
            <h3 class="text-lg font-semibold text-pink-600 mb-4">Edit User</h3>
            <form method="POST" :action="'/users/' + selectedUser?.id">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm mb-1">Nama</label>
                    <input type="text" name="name" x-model="selectedUser.name" class="w-full border px-3 py-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm mb-1">Email</label>
                    <input type="email" name="email" x-model="selectedUser.email" class="w-full border px-3 py-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm mb-1">Telepon</label>
                    <input type="text" name="telepon" x-model="selectedUser.telepon" class="w-full border px-3 py-2 rounded">
                </div>
                <div class="mb-4">
                    <label class="block text-sm mb-1">Alamat</label>
                    <input type="text" name="alamat" x-model="selectedUser.alamat" class="w-full border px-3 py-2 rounded">
                </div>

                <div class="text-right">
                    <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded">Update</button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-6 flex justify-center">
        {{ $users->links() }}
    </div>

</div>
@endsection