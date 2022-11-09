<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstimationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estimations')->insert([
            'umkms_id' => '3',
            'name_process' => 'prepare',
            'urutan' => '1',
            'durasi' => '2'
        ]);

        DB::table('estimations')->insert([
            'umkms_id' => '3',
            'name_process' => 'print',
            'urutan' => '2',
            'durasi' => '4'
        ]);

        DB::table('estimations')->insert([
            'umkms_id' => '3',
            'name_process' => 'pengeringan',
            'urutan' => '3',
            'durasi' => '5'
        ]);

        DB::table('estimations')->insert([
            'umkms_id' => '4',
            'name_process' => 'desain',
            'urutan' => '1',
            'durasi' => '3'
        ]);

        DB::table('estimations')->insert([
            'umkms_id' => '4',
            'name_process' => 'print',
            'urutan' => '2',
            'durasi' => '10'
        ]);

        DB::table('estimations')->insert([
            'umkms_id' => '4',
            'name_process' => 'packing',
            'urutan' => '3',
            'durasi' => '6'
        ]);
    }
}
