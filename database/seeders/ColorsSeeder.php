<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('colors')->insert([
            'umkms_id' => '3',
            'name' => 'White',
        ]);
        DB::table('colors')->insert([
            'umkms_id' => '3',
            'name' => 'Black',
        ]);
        DB::table('colors')->insert([
            'umkms_id' => '4',
            'name' => 'Green',
        ]);
        DB::table('colors')->insert([
            'umkms_id' => '4',
            'name' => 'Blue',
        ]);
    }
}
