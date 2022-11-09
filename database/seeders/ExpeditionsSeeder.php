<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpeditionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('expeditions')->insert([
            'umkms_id' => '3',
            'name' => 'JNE',
            'type' => 'reguler',
            'price' => '15000',
            'phone' => '0908956645'
        ]);

        DB::table('expeditions')->insert([
            'umkms_id' => '3',
            'name' => 'JNT',
            'type' => 'reguler',
            'price' => '25000',
            'phone' => '0908956645'
        ]);

        DB::table('expeditions')->insert([
            'umkms_id' => '3',
            'name' => 'SI CEPAT',
            'type' => 'reguler',
            'price' => '17000',
            'phone' => '0908956645'
        ]);
    }
}
