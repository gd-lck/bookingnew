@extends('layouts.app')

@section('title', 'Jadwal')

@section('content')
<div x-data="{ tambahModal: false, editModalId: null }" class="py-10 pl-72">
    <h2 class="text-2xl font-bold text-pink-600 mb-6">Jadwal Karyawan</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <button @click="tambahModal = true" class="bg-pink-500 hover:bg-pink-600 text-white font-semibold px-4 py-2 rounded mb-4">
        Tambah Jadwal
    </button>

    <!-- Modal Tambah -->
    <div x-show="tambahModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div @click.outside="tambahModal = false" class="bg-white p-6 rounded shadow w-full max-w-md">
            <h5 class="text-lg font-semibold text-pink-600 mb-4">Tambah Jadwal Karyawan</h5>
            <form action="{{ route('jadwal.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm mb-1">Tanggal</label>
                    <input type="date" name="tanggal" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm mb-1">Karyawan</label>
                    <select name="karyawan_id" class="w-full border rounded px-3 py-2" required>
                        @foreach($karyawans as $karyawan)
                            <option value="{{ $karyawan->id }}">{{ $karyawan->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-sm mb-1">Shift</label>
                    <select name="shift" class="w-full border rounded px-3 py-2" required>
                        <option value="opening">Opening (08:00 - 17:00)</option>
                        <option value="middle">Middle (11:00 - 20:00)</option>
                        <option value="closing">Closing (13:00 - 22:00)</option>
                        <option value="libur">Libur</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                    <button type="button" @click="tambahModal = false" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white text-sm text-gray-700 border border-gray-200 rounded shadow">
            <thead class="bg-pink-100 text-pink-700">
                <tr>
                    <th class="py-2 px-4 text-left">Hari</th>
                    @foreach($karyawans as $karyawan)
                        <th class="py-2 px-4 text-left">{{ $karyawan->nama }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($jadwals as $tanggal => $data)
                <tr class="border-t">
                    <td class="py-2 px-4 font-medium">{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d M Y') }}</td>
                    @foreach($karyawans as $karyawan)
                        @php
                            $jadwal = $data->firstWhere('karyawan_id', $karyawan->id);
                        @endphp
                        <td class="py-2 px-4">
                            @if($jadwal)
                                <span class="block mb-1">{{ ucfirst($jadwal->shift) }}</span>
                                <button @click="editModalId = {{ $jadwal->id }}" class="bg-yellow-400 hover:bg-yellow-500 text-white text-xs px-2 py-1 rounded mr-2">Edit</button>
                                <form action="{{ route('jadwal.destroy', $jadwal->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus jadwal ini?')" class="bg-red-500 hover:bg-red-600 text-white text-xs px-2 py-1 rounded">Hapus</button>
                                </form>

                                <!-- Modal Edit -->
                                <div x-show="editModalId === {{ $jadwal->id }}" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                    <div @click.outside="editModalId = null" class="bg-white p-6 rounded shadow w-full max-w-md">
                                        <h5 class="text-lg font-semibold text-pink-600 mb-4">Edit Jadwal</h5>
                                        <form action="{{ route('jadwal.update', $jadwal->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label class="block text-sm mb-1">Karyawan</label>
                                                <select name="karyawan_id" class="w-full border rounded px-3 py-2">
                                                    @foreach($karyawans as $k)
                                                        <option value="{{ $k->id }}" {{ $k->id == $jadwal->karyawan_id ? 'selected' : '' }}>{{ $k->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="block text-sm mb-1">Shift</label>
                                                <select name="shift" class="w-full border rounded px-3 py-2">
                                                    <option value="opening" {{ $jadwal->shift == 'opening' ? 'selected' : '' }}>Opening (08:00 - 17:00)</option>
                                                    <option value="middle" {{ $jadwal->shift == 'middle' ? 'selected' : '' }}>Middle (11:00 - 20:00)</option>
                                                    <option value="closing" {{ $jadwal->shift == 'closing' ? 'selected' : '' }}>Closing (13:00 - 22:00)</option>
                                                    <option value="libur" {{ $jadwal->shift == 'libur' ? 'selected' : '' }}>Libur</option>
                                                </select>
                                            </div>
                                            <div class="flex justify-end gap-2 mt-4">
                                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                                                <button type="button" @click="editModalId = null" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Batal</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <span class="text-gray-500 italic">Belum dijadwalkan</span>
                            @endif
                        </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

