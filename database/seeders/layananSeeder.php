<?php

namespace Database\Seeders;

use App\Models\Layanan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class layananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $layanan = Layanan::create([
            'nama_layanan'=>'basic',
            'harga'=>100,
            'durasi'=>60,
            'deskripsi'=>'lorem ipsum sit dolor',
            'gambar'=>'gambar1.jpg',
            
        ]);
    }
}
