<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Http\Request;
use App\Models\Layanan;

class LayananController extends Controller
{
    public function index(){
        $layanan = Layanan::all();
        
        return view('admin.layanan.index', compact('layanan'));
    }
    
    public function displayLayanan(){
        $layanan = Layanan::all();
        return view('customer.layanan', compact('layanan'));
    }

    public function create(){
        return view('admin.layanan.index');
    }

    public function store(Request $request){
     
        $request->validate([
            'nama_layanan' => 'required|string|max:50',
            'harga' => 'required|numeric|min:0',
            'durasi' => 'required|numeric|min:0',
            'deskripsi' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'gambar2' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
        try{
        // Simpan Gambar dengan Nama Unik
        $imageName = time().'_1.'.$request->gambar->extension();
        $request->gambar->move(public_path('uploads'), $imageName);

        $image2Name = null; 
        if($request->hasFile('gambar2')){
            $image2Name = time().'_2.'.$request->gambar2->extension();
            $request->gambar2->move(public_path('uploads'), $image2Name);
        }

        
        // Simpan ke Database
        Layanan::create([
            'nama_layanan' => $request->nama_layanan,
            'harga' => $request->harga,
            'durasi' => $request->durasi,
            'deskripsi' => $request->deskripsi,
            'gambar' => $imageName,
            'gambar2' => $image2Name
        ]);
    
        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil ditambahkan');

     }catch(exception $e){
            Log::error('Gagal Menambahkan layanan: '.$e->getMessage());

            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menambahkan layanan. Silakan coba lagi.');
        }
    }

    public function edit($id)
    {
        $layanan = Layanan::findOrFail($id);
        return view('layanan.edit', compact('layanan'));
    }

   
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:50',
            'harga' => 'required|numeric|min:0',
            'durasi' => 'required|numeric|min:0',
            'deskripsi' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gambar2' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            $layanan = Layanan::findOrFail($id);

            $layanan->nama_layanan = $request->nama_layanan;
            $layanan->harga = $request->harga;
            $layanan->durasi = $request->durasi;
            $layanan->deskripsi = $request->deskripsi;

            // Upload gambar 1
            if ($request->hasFile('gambar')) {
                $imageName = time() . '_1.' . $request->gambar->extension();
                $request->gambar->move(public_path('uploads'), $imageName);

               
                if ($layanan->gambar && file_exists(public_path('uploads/' . $layanan->gambar))) {
                    unlink(public_path('uploads/' . $layanan->gambar));
                }

                $layanan->gambar = $imageName;
            }

            // Upload gambar 2
            if ($request->hasFile('gambar2')) {
                $image2Name = time() . '_2.' . $request->gambar2->extension();
                $request->gambar2->move(public_path('uploads'), $image2Name);

                if ($layanan->gambar2 && file_exists(public_path('uploads/' . $layanan->gambar2))) {
                    unlink(public_path('uploads/' . $layanan->gambar2));
                }

                $layanan->gambar2 = $image2Name;
            }

            $layanan->save();

            return redirect()->route('layanan.index')->with('success', 'Layanan berhasil diperbarui');

        } catch (Exception $e) {
            Log::error('Gagal update layanan: '.$e->getMessage());

            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui layanan. Silakan coba lagi.');
        }
    }


    public function destroy($id)
    {
        $layanan = Layanan::findOrFail($id);
        
        // Hapus gambar dari penyimpanan jika ada
        if ($layanan->gambar && file_exists(public_path('uploads/'.$layanan->gambar))) {
            unlink(public_path('uploads/'.$layanan->gambar));
        }
        
        $layanan->delete();
        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil dihapus');
    }

    
}


