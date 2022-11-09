<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Detail_ordersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('detail_orders')->insert([
            'orders_id' => '1',
            'umkms_id' => '3',
            'products_id' => '1',
            'detail_products_id' => '1',
            'products_name' => 'Uzumaki Naruto',
            'category' => 'Naruto',
            'size' => 's',
            'color' => 'black',
            'qty' => '1',
            'price' => '90000',
            'subtotal' => '90000',
            'created_at' => '2022-09-08 18:36:50',
            'updated_at' => '2022-09-08 18:36:50',
        ]);

        DB::table('detail_orders')->insert([
            'orders_id' => '1',
            'umkms_id' => '3',
            'products_id' => '1',
            'detail_products_id' => '2',
            'products_name' => 'Uzumaki Naruto',
            'category' => 'Naruto',
            'size' => 'm',
            'color' => 'white',
            'qty' => '1',
            'price' => '90000',
            'subtotal' => '90000',
            'created_at' => '2022-09-08 18:36:50',
            'updated_at' => '2022-09-08 18:36:50',
        ]);

        DB::table('detail_orders')->insert([
            'orders_id' => '2',
            'umkms_id' => '4',
            'products_id' => '3',
            'detail_products_id' => '5',
            'products_name' => 'PPKM',
            'category' => 'covid',
            'size' => 's',
            'color' => 'green',
            'qty' => '5',
            'price' => '90000',
            'subtotal' => '450000',
            'created_at' => '2022-09-08 18:36:50',
            'updated_at' => '2022-09-08 18:36:50',
        ]);


        DB::table('detail_orders')->insert([
            'orders_id' => '3',
            'umkms_id' => '3',
            'products_id' => '1',
            'detail_products_id' => '1',
            'products_name' => 'Uzumaki Naruto',
            'category' => 'Naruto',
            'size' => 's',
            'color' => 'black',
            'qty' => '1',
            'price' => '90000',
            'subtotal' => '90000',
            'created_at' => '2022-09-05 18:36:50',
            'updated_at' => '2022-09-05 18:36:50',
        ]);
    }
}
