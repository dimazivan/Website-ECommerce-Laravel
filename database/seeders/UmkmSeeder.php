<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UmkmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('umkms')->insert([
            'owner_name' => 'SUPER',
            'umkm_name' => 'SUPER',
            'location' => 'SUPER',
            'districts' => 'sambikerep',
            'ward' => 'sambikerep',
            'city' => 'surabaya',
            'province' => 'jawa timur',
            'postal_code' => '41231',
            'phone' => '1111111',
            'open_time' => '08:00:00',
            'close_time' => '18:00:00',
        ]);

        DB::table('umkms')->insert([
            'owner_name' => 'CUSTOMER',
            'umkm_name' => 'CUSTOMER',
            'location' => 'CUSTOMER',
            'districts' => 'sambikerep',
            'ward' => 'sambikerep',
            'city' => 'surabaya',
            'province' => 'jawa timur',
            'postal_code' => '41231',
            'phone' => '00000000',
            'open_time' => '08:00:00',
            'close_time' => '18:00:00',
        ]);

        DB::table('umkms')->insert([
            'owner_name' => 'Herwanda',
            'umkm_name' => 'Elite Store',
            'location' => 'Madiun',
            'districts' => 'sambikerep',
            'ward' => 'sambikerep',
            'city' => 'madiun',
            'province' => 'jawa timur',
            'postal_code' => '41231',
            'phone' => '0123208',
            'open_time' => '08:00:00',
            'close_time' => '18:00:00',
        ]);

        DB::table('umkms')->insert([
            'owner_name' => 'Dimaz UMKM',
            'umkm_name' => 'Dimz Store',
            'location' => 'Dk. Jelidro Kavling III',
            'districts' => 'sambikerep',
            'ward' => 'sambikerep',
            'city' => 'surabaya',
            'province' => 'jawa timur',
            'postal_code' => '41231',
            'phone' => '01534353',
            'open_time' => '08:00:00',
            'close_time' => '18:00:00',
        ]);
    }
}
