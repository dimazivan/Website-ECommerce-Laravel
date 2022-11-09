<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orders')->insert([
            'users_id' => '2',
            'date' => '2022-09-08',
            'first_name' => 'Customer',
            'last_name' => 'Seeder 1',
            'phone' => '082180120',
            'postal_code' => '11111',
            'address' => 'Jalan Seeder 1 No.1',
            'districts' => 'Kecamatan Seeder',
            'ward' => 'Kelurahan Seeder',
            'city' => 'Kota Seeder',
            'province' => 'Provinsi Seeder',
            'desc' => 'Lurus Kanan Seeder',
            'tgl_pengiriman' => '2022-08-06',
            'potongan' => '0',
            'total' => '190000',
            'status' => 'Selesai',
            'pict_payment' => 'payment.jpg',
            'status_payment' => 'Lunas',
            'keterangan' => 'Order 1 ya Seeder 1',
            'shipping' => 'JNE reguler',
            'no_resi' => '111-1111-111-11',
            'status_shipping' => 'Selesai',
            'ongkir' => '10000',
            'created_at' => '2022-09-08 18:36:50',
            'updated_at' => '2022-09-08 18:36:50',
        ]);

        DB::table('orders')->insert([
            'users_id' => '2',
            'date' => '2022-09-08',
            'first_name' => 'Customer',
            'last_name' => 'Seeder 2',
            'phone' => '082180120',
            'postal_code' => '22222',
            'address' => 'Jalan Seeder 2 No.2',
            'districts' => 'Kecamatan Seeder',
            'ward' => 'Kelurahan Seeder',
            'city' => 'Kota Seeder',
            'province' => 'Provinsi Seeder',
            'desc' => 'Lurus Kanan Seeder',
            'tgl_pengiriman' => '2022-08-06',
            'potongan' => '0',
            'total' => '470000',
            'status' => 'Selesai',
            'pict_payment' => 'payment.jpg',
            'status_payment' => 'Lunas',
            'keterangan' => 'Order 2 ya Seeder 2',
            'shipping' => 'JNE reguler',
            'no_resi' => '222-2222-222-22',
            'status_shipping' => 'Selesai',
            'ongkir' => '20000',
            'created_at' => '2022-09-08 18:36:50',
            'updated_at' => '2022-09-08 18:36:50',
        ]);

        DB::table('orders')->insert([
            'users_id' => '2',
            'date' => '2022-09-05',
            'first_name' => 'Customer',
            'last_name' => 'Seeder 2',
            'phone' => '082180120',
            'postal_code' => '22222',
            'address' => 'Jalan Seeder 2 No.2',
            'districts' => 'Kecamatan Seeder',
            'ward' => 'Kelurahan Seeder',
            'city' => 'Kota Seeder',
            'province' => 'Provinsi Seeder',
            'desc' => 'Lurus Kanan Seeder',
            'potongan' => '0',
            'total' => '90000',
            'status' => 'Menunggu Konfirmasi',
            'keterangan' => 'Order 2 ya Seeder 2',
            'shipping' => 'JNE reguler',
            'created_at' => '2022-09-05 18:36:50',
            'updated_at' => '2022-09-05 18:36:50',
        ]);
    }
}
