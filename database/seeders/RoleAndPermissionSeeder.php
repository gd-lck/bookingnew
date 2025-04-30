<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        permission::create(['name'=>'kelola-user']);
        permission::create(['name'=>'kelola-profil']);
        permission::create(['name'=>'kelola-booking']);
        permission::create(['name'=>'lihat-booking']);

        permission::create(['name'=>'lihat-layanan']);
        permission::create(['name'=>'booking']);
        permission::create(['name'=> 'reschedule']);

        role::create(['name'=>'admin']);
        role::create(['name'=>'customer']);

        $roleAdmin= Role::findByName('admin');
        $roleCustomer = Role::findByName('customer');

        $roleAdmin -> givePermissionTo('kelola-user');
        $roleAdmin -> givePermissionTo('kelola-profil');
        $roleAdmin -> givePermissionTo('kelola-booking');
        $roleAdmin -> givePermissionTo('lihat-booking');

        $roleCustomer-> givePermissionTo('lihat-layanan');
        $roleCustomer-> givePermissionTo('booking');
        $roleCustomer-> givePermissionTo('reschedule');
        
    }
}
  