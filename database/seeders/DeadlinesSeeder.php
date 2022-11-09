<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeadlinesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('deadlines')->insert([
            'umkms_id' => '3',
            'deadline' => '48',
        ]);

        DB::table('deadlines')->insert([
            'umkms_id' => '4',
            'deadline' => '48',
        ]);
    }
}
