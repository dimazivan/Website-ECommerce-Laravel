<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'umkms_id' => '3',
            'name' => 'Uzumaki Naruto',
            'category' => 'Naruto',
            'desc' => 'Kaos sablon yang bertemakan Animasi Naruto dengan mengambil karakter ataupun inspirasi ide desain dari tema tersebut.',
            'pict_1' => 'product_naruto.jpg',
            'pict_2' => 'product_naruto.jpg',
            'pict_3' => 'product_naruto.jpg',
        ]);

        DB::table('products')->insert([
            'umkms_id' => '3',
            'name' => 'Agustusan',
            'category' => 'Kemerdekaan',
            'desc' => 'Kaos sablon yang bertemakan Hari Nasional Kemerderkaan Republik Indonesia dengan mengambil insipirasi ide desain dari tema tersebut.',
            'pict_1' => 'product_agustusan.jpg',
            'pict_2' => 'product_agustusan.jpg',
            'pict_3' => 'product_agustusan.jpg',
        ]);

        DB::table('products')->insert([
            'umkms_id' => '4',
            'name' => 'PPKM',
            'category' => 'Covid',
            'desc' => 'Kaos sablon yang bertemakan Pandemic dan bertulisan PPKM dengan mengambil inspirasi ide desain dari tema tersebut.',
            'pict_1' => 'product_ppkm.jpg',
            'pict_2' => 'product_ppkm.jpg',
            'pict_3' => 'product_ppkm.jpg',
        ]);

        DB::table('products')->insert([
            'umkms_id' => '4',
            'name' => 'Kudapan Kandara',
            'category' => 'Ramen',
            'desc' => 'Kaos sablon yang bertemakan makanan dan minuman dengan mengambil insipirasi ide desain dari tema tersebut.',
            'pict_1' => 'product_rame.png',
            'pict_2' => 'product_rame.png',
            'pict_3' => 'product_rame.png',
        ]);
    }
}
