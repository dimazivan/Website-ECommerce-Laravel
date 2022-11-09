<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Detail_productsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('detail_products')->insert([
            'products_id' => '1',
            'color' => 'black',
            'modal' => '80000',
            'price' => '100000',
            'promo' => '90000',
            'size' => 's',
            'qty' => '20',
        ]);

        DB::table('detail_products')->insert([
            'products_id' => '1',
            'color' => 'white',
            'modal' => '80000',
            'price' => '100000',
            'promo' => '90000',
            'size' => 'm',
            'qty' => '10',
        ]);

        DB::table('detail_products')->insert([
            'products_id' => '2',
            'color' => 'white',
            'modal' => '100000',
            'price' => '120000',
            'promo' => '110000',
            'size' => 'l',
            'qty' => '25',
        ]);
        
        DB::table('detail_products')->insert([
            'products_id' => '2',
            'color' => 'black',
            'modal' => '80000',
            'price' => '100000',
            'promo' => '90000',
            'size' => 'xl',
            'qty' => '10',
        ]);

        DB::table('detail_products')->insert([
            'products_id' => '3',
            'color' => 'green',
            'modal' => '80000',
            'price' => '100000',
            'promo' => '90000',
            'size' => 's',
            'qty' => '20',
        ]);

        DB::table('detail_products')->insert([
            'products_id' => '3',
            'color' => 'blue',
            'modal' => '80000',
            'price' => '100000',
            'promo' => '90000',
            'size' => 'l',
            'qty' => '19',
        ]);

        DB::table('detail_products')->insert([
            'products_id' => '4',
            'color' => 'green',
            'modal' => '100000',
            'price' => '120000',
            'promo' => '110000',
            'size' => 'xl',
            'qty' => '23',
        ]);
        
        DB::table('detail_products')->insert([
            'products_id' => '4',
            'color' => 'blue',
            'modal' => '80000',
            'price' => '100000',
            'promo' => '90000',
            'size' => 'xxl',
            'qty' => '11',
        ]);
    }
}
