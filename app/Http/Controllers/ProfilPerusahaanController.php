<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profil_perusahaan;
use Illuminate\Support\Facades\Storage;

class ProfilPerusahaanController extends Controller
{
    public function edit()
    {
        $perusahaan = Profil_perusahaan::firstOrCreate([]);
        return view('admin.perusahaan.edit', compact('perusahaan'));
    }

    public function update(Request $request)
    {
        $perusahaan = Profil_perusahaan::first();

        $validated = $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($perusahaan->logo) {
                Storage::disk('public')->delete($perusahaan->logo);
            }
            $validated['logo'] = $request->file('logo')->store('logo', 'public');
        }

        $perusahaan->update($validated);

        return redirect()->route('perusahaan.edit')->with('success', 'Data perusahaan diperbarui.');
    }
}
