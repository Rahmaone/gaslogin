<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;


class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'pengguna_biasa']);

        $admin = User::find(1); 
        $admin->assignRole('admin');

        $user = User::find(2); 
        $user->assignRole('pengguna_biasa');
    }
}
