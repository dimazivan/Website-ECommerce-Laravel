<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('materials')->insert([
            'umkms_id' => '3',
            'suppliers_id' => '1',
            'name' => 'tote bag',
            'price' => '3000',
            'qty' => '50'
        ]);

        DB::table('materials')->insert([
            'umkms_id' => '3',
            'suppliers_id' => '2',
            'name' => 'stiker lucu 01',
            'price' => '300',
            'qty' => '100'
        ]);
    }
}
