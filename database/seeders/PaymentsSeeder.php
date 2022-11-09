<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payments')->insert([
            'umkms_id' => '3',
            'name' => 'BCA',
            'name_account' => 'Dimaz Ivan Perdana',
            'type' => 'BANK TRANSFER',
            'number' => '3421123'
        ]);

        DB::table('payments')->insert([
            'umkms_id' => '3',
            'name' => 'OVO',
            'name_account' => 'Dimaz Ivan Perdana',
            'type' => 'DIGITAL WALLET',
            'number' => '085445456456'
        ]);
        
        DB::table('payments')->insert([
            'umkms_id' => '4',
            'name' => 'BRI',
            'name_account' => 'Dimaz Ivan Perdana2',
            'type' => 'BANK TRANSFER',
            'number' => '544543'
        ]);

        DB::table('payments')->insert([
            'umkms_id' => '4',
            'name' => 'DANA',
            'name_account' => 'Dimaz Ivan Perdana2',
            'type' => 'DIGITAL WALLET',
            'number' => '085123456'
        ]);
    }
}
