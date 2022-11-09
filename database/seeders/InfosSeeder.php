<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InfosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('infos')->insert([
            'umkms_id' => '1',
            'no_wa' => '0812971297',
            'title' => 'Sistem Informasi',
            'alamat' => 'Jl. Manukan Lor IV F No. 32',
            'link_tokped' => 'https://www.tokopedia.com/',
            'link_shopee' => 'https://shopee.co.id/',
            'link_email' => 'dimaz@gmail.com',
            'link_instagram' => 'https://www.instagram.com/dimazivan/',
            'description_login' => 'Masukkan username dan password anda dengan benar sesuai
            data yang terdaftar pada halaman website',
            'description_register' => 'Harap masukkan data-data dengan benar untuk keperluan transaksi',
            'description_umkm' => 'Sistem informasi yang membantu Anda dalam 
            melakukan transaksi pembelian dan pemesanan produk sablon 
            secara online praktis dan efektif',
            'description_product' => 'Sistem informasi yang membantu Anda dalam 
            melakukan transaksi pembelian dan pemesanan produk sablon 
            secara online praktis dan efektif',
            'description_detail' => 'Sistem informasi yang membantu Anda dalam 
            melakukan transaksi pembelian dan pemesanan produk sablon 
            secara online praktis dan efektif',
            'description_lainnya' => 'Sistem informasi yang membantu Anda dalam 
            melakukan transaksi pembelian dan pemesanan produk sablon 
            secara online praktis dan efektif',
            'date' => '2022-02-09'
        ]);

        DB::table('infos')->insert([
            'umkms_id' => '2',
            'no_wa' => '0812971297',
            'title' => 'Sistem Informasi',
            'alamat' => 'Jl. Manukan Lor IV F No. 32',
            'link_tokped' => 'https://www.tokopedia.com/',
            'link_shopee' => 'https://shopee.co.id/',
            'link_email' => 'dimaz@gmail.com',
            'link_instagram' => 'https://www.instagram.com/dimazivan/',
            'description_login' => 'Masukkan username dan password anda dengan benar sesuai
            data yang terdaftar pada halaman website',
            'description_register' => 'Harap masukkan data-data dengan benar untuk keperluan transaksi',
            'description_umkm' => 'Sistem informasi yang membantu Anda dalam 
            melakukan transaksi pembelian dan pemesanan produk sablon 
            secara online praktis dan efektif',
            'description_product' => 'Sistem informasi yang membantu Anda dalam 
            melakukan transaksi pembelian dan pemesanan produk sablon 
            secara online praktis dan efektif',
            'description_detail' => 'Sistem informasi yang membantu Anda dalam 
            melakukan transaksi pembelian dan pemesanan produk sablon 
            secara online praktis dan efektif',
            'description_lainnya' => 'Sistem informasi yang membantu Anda dalam 
            melakukan transaksi pembelian dan pemesanan produk sablon 
            secara online praktis dan efektif',
            'date' => '2022-02-09'
        ]);

        DB::table('infos')->insert([
            'umkms_id' => '3',
            'no_wa' => '0812971297',
            'title' => 'Elite Web Store',
            'alamat' => 'Jl. Kelapa Sari No. 50 B, Kota Madiun',
            'link_tokped' => 'https://www.tokopedia.com/Elite',
            'link_shopee' => 'https://shopee.co.id/Elite',
            'link_email' => 'dimazELITE@gmail.com',
            'link_instagram' => 'https://www.instagram.com/dimazivan/',
            'description_login' => '',
            'description_register' => '',
            'description_umkm' => 'Ini halaman umkm ELITE',
            'description_product' => 'Ini halaman product ELITE',
            'description_detail' => 'Ini halaman detail product ELITE',
            'description_lainnya' => 'Ini halaman lainnya ELITE',
            'date' => '2022-02-10'
        ]);

        DB::table('infos')->insert([
            'umkms_id' => '4',
            'no_wa' => '0812971297',
            'title' => 'Dimz Store',
            'alamat' => 'Jl. UMKM dimaz',
            'link_tokped' => 'https://www.tokopedia.com/DimzStore',
            'link_shopee' => 'https://shopee.co.id/DimzStore',
            'link_email' => 'dimazDIMZ@gmail.com',
            'link_instagram' => 'https://www.instagram.com/dimazivan/',
            'description_login' => '',
            'description_register' => '',
            'description_umkm' => 'Ini halaman umkm Dimz Store',
            'description_product' => 'Ini halaman product Dimz Store',
            'description_detail' => 'Ini halaman detail product Dimz Store',
            'description_lainnya' => 'Ini halaman lainnya Dimz Store',
            'date' => '2022-02-10'
        ]);
    }
}
