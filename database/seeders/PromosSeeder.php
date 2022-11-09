<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('promos')->insert([
            'umkms_id' => '3',
            'name' => 'PROMO 17 17',
            'kode' => '17081945',
            'type' => 'nominal',
            'jumlah' => '10000',
            'create_date' => '2022-02-10',
            'status' => 'aktif'
        ]);

        DB::table('promos')->insert([
            'umkms_id' => '3',
            'name' => 'PROMO 17',
            'kode' => '1717',
            'type' => 'discount',
            'jumlah' => '10',
            'create_date' => '2022-02-10',
            'status' => 'tidak_aktif'
        ]);

        DB::table('promos')->insert([
            'umkms_id' => '4',
            'name' => 'PROMO GRAND OPENING',
            'kode' => '113125',
            'type' => 'nominal',
            'jumlah' => '12000',
            'create_date' => '2022-02-10',
            'status' => 'aktif'
        ]);
    }
}
