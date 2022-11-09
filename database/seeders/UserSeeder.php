<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'umkms_id' => '1',
            'username' => 'adminsuper',
            'email' => 'dimz@gmail.com',
            'password' => bcrypt('dimazivan'),
            'role' => 'super',
        ]);

        DB::table('users')->insert([
            'umkms_id' => '2',
            'username' => 'customer',
            'email' => 'customer@gmail.com',
            'password' => bcrypt('customer'),
            'role' => 'user',
        ]);

        DB::table('users')->insert([
            'umkms_id' => '3',
            'username' => 'dimazivan',
            'email' => 'dimaz@gmail.com',
            'password' => bcrypt('dimazivan'),
            'role' => 'admin',
        ]);

        DB::table('users')->insert([
            'umkms_id' => '3',
            'username' => 'adminproduksi',
            'email' => 'dimaz124@gmail.com',
            'password' => bcrypt('dimazivan'),
            'role' => 'produksi',
        ]);

        DB::table('users')->insert([
            'umkms_id' => '4',
            'username' => 'admindimaz',
            'email' => 'admindimaz@gmail.com',
            'password' => bcrypt('dimazivan'),
            'role' => 'admin',
        ]);
    }
}
