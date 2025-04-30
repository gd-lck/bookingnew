<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::all();
        $jadwals = Jadwal::all()->groupBy('tanggal');

        return view('admin.jadwal.index', compact('karyawans', 'jadwals'));
    }

    public function store(Request $request)
    {   
        $request->validate([
            'tanggal' => 'required|date',
            'karyawan_id' => 'required|exists:karyawans,id',
            'shift' => 'required|in:opening,middle,closing,libur',
        ]);

        [$jamMulai, $jamSelesai] = Jadwal::getJamShift($request->shift);

        Jadwal::create([
            'karyawan_id' => $request->karyawan_id,
            'tanggal' => $request->tanggal,
            'shift' => $request->shift,
            'jam_mulai' => $jamMulai,
            'jam_selesai' => $jamSelesai,
        ]);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

        public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $karyawans = karyawan::all();

        return view('jadwal.edit', compact('jadwal', 'karyawans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'shift' => 'required|in:opening,middle,closing,libur',
        ]);

        [$jamMulai, $jamSelesai] = Jadwal::getJamShift($request->shift);

        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update([
            'karyawan_id' => $request->karyawan_id,
            'shift' => $request->shift,
            'jam_mulai' => $jamMulai,
            'jam_selesai' => $jamSelesai,
        ]);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Jadwal::findOrFail($id)->delete();
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
    }

}
