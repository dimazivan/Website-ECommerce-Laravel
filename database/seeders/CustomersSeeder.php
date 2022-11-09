<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->insert([
            'users_id' => '1',
            'first_name' => 'Dimaz',
            'last_name' => 'super',
            'address' => 'Dk. Jelidro Kavling III',
            'districts' => 'sambikerep',
            'ward' => 'sambikerep',
            'city' => 'surabaya',
            'province' => 'jawa timur',
            'postal_code' => '41231',
            'phone' => '081236268316',
            'desc' => 'super',
        ]);

        DB::table('customers')->insert([
            'users_id' => '2',
            'first_name' => 'Customer',
            'last_name' => 'Seeder',
            'address' => 'Jl. Mawar Wangi',
            'districts' => 'tandes',
            'ward' => 'tandes',
            'city' => 'surabaya',
            'province' => 'jawa timur',
            'postal_code' => '42321',
            'phone' => '0232311236',
            'desc' => 'lurus kanan rumah customer',
        ]);


        DB::table('customers')->insert([
            'users_id' => '3',
            'first_name' => 'Dimaz',
            'last_name' => 'Ivan',
            'address' => 'Dk. Jelidro Kavling III',
            'districts' => 'sambikerep',
            'ward' => 'sambikerep',
            'city' => 'surabaya',
            'province' => 'jawa timur',
            'postal_code' => '41231',
            'phone' => '081236268316',
            'desc' => 'mantab',
        ]);

        DB::table('customers')->insert([
            'users_id' => '4',
            'first_name' => 'Dimaz',
            'last_name' => 'Ivan',
            'address' => 'Dk. Jelidro Kavling III',
            'districts' => 'sambikerep',
            'ward' => 'sambikerep',
            'city' => 'surabaya',
            'province' => 'jawa timur',
            'postal_code' => '41231',
            'phone' => '081236268316',
            'desc' => 'mantab',
        ]);

        DB::table('customers')->insert([
            'users_id' => '5',
            'first_name' => 'Dimaz',
            'last_name' => 'Dimaz',
            'address' => 'Jl. Wangi',
            'districts' => 'jambaran',
            'ward' => 'jambaran',
            'city' => 'surabaya',
            'province' => 'jawa timur',
            'postal_code' => '42321',
            'phone' => '0999996',
            'desc' => 'b',
        ]);
    }
}
