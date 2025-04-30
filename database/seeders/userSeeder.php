<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = User::create([
            'name'=>'customer1',
            'email'=>'customer1@google.com',
            'password'=>bcrypt('customer123')
        ]);

        $customer -> assignRole('customer');

        $admin = User::create([
            'name' => 'admin1',
            'email' => 'admin1@google',
            'password' => bcrypt('admin123')
        ]);

        $admin -> assignRole('admin');

    }
}
