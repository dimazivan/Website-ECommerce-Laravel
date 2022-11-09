<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categorys')->insert([
            'umkms_id' => '3',
            'name' => 'Naruto',
        ]);
        DB::table('categorys')->insert([
            'umkms_id' => '3',
            'name' => 'Kemerdekaan',
        ]);
        DB::table('categorys')->insert([
            'umkms_id' => '4',
            'name' => 'Covid',
        ]);
        DB::table('categorys')->insert([
            'umkms_id' => '4',
            'name' => 'Ramen',
        ]);
    }
}
