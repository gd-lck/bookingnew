<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Layanan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index(){
        $karyawan = Karyawan::all();
        return view('admin.karyawan.index', compact('karyawan'));
    }
    
    public function store(Request $request){
        $request->validate([
            'nama' => 'required|string|max:50',
            'email' => 'required|email|unique:karyawans,email',
            'status_kerja' => 'required|string|max:15'
        ]);

        Karyawan::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'status_kerja' => $request->status_kerja
        ]);

        return redirect()->route('karyawan.index')->with('success','Layanan berhasil ditambahkan');
    }

    public function edit($id){
        $karyawan = Karyawan::findOrFail($id);
        return view('karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, $id){

        $request->validate([
            'nama' => 'required|string|max:50',
            'email' => 'required|email',
            'status_kerja' => 'required|string|max:15'
        ]);
        
        $karyawan = Karyawan::findOrFail($id);

        $karyawan->nama = $request->nama;
        $karyawan->email = $request->email;
        $karyawan->status_kerja = $request->status_kerja;

        $karyawan->save();

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diperbarui');
    }

    public function destroy($id){
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();
        return redirect()->route('karyawan.index')->with('success', 'Data berhasil dihapus');
    }
}
