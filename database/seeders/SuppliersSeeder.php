<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuppliersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('suppliers')->insert([
            'umkms_id' => '3',
            'name' => 'Jupri',
            'address' => 'Jl. Sukun II',
            'email' => 'suppliers01@gmail.com',
            'phone' => '08123283713'
        ]);

        DB::table('suppliers')->insert([
            'umkms_id' => '3',
            'name' => 'Supri',
            'address' => 'Jl. Sukun III',
            'email' => 'suppliers02@gmail.com',
            'phone' => '08162346456'
        ]);
    }
}
