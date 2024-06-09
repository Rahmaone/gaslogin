<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'pengguna_biasa']);

        $admin = User::create([
            'name'      => 'AgungFathulMuhtadin',
            'email'     => 'agungfathul14@gmail.com',
            'password'  => Hash::make('qt7htrq5y7o'),
            'role'      => 'admin',
            'isActive'  => false,
        ]);
        $admin->assignRole($adminRole);

        $user = User::create([
            'name'      => 'RakaIndraRahmawan',
            'email'     => 'rirahmawan@gmail.com',
            'password'  => Hash::make('testpassword'),
            'isActive'  => false,
        ]);
        $user->assignRole($userRole);
    }
}