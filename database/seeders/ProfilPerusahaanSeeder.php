<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Profil_perusahaan;
use Illuminate\Database\Seeder;

class ProfilPerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profil_perusahaan = Profil_perusahaan::create([
            'nama_perusahaan' => 'Yours Beauty',
            'telepon'=>'0885737867453',
            'email' => 'yourbeauty@google.com',
            'alamat' => 'jln. kesiman',
            'logo'=> 'qNPSdrleIizgzZBXIN2Khng5Vq2Vctlgz7snkAjl.png',
            'website'=>'https://yourbeauty.id'
        ]);
    }
}
