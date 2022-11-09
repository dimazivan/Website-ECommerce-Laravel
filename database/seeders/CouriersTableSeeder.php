<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Courier;

class CouriersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'code' => 'jne',
                'title' => 'JNE'
            ],
            [
                'code' => 'pos',
                'title' => 'POS'
            ],
            [
                'code' => 'tiki',
                'title' => 'TIKI'
            ]
        ];
        // insert
        Courier::insert($data);
    }
}
