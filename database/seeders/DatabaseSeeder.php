<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            UmkmSeeder::class,
            // BannersSeeder::class,
            UserSeeder::class,
            CustomersSeeder::class,
            ProductsSeeder::class,
            Detail_productsSeeder::class,
            SuppliersSeeder::class,
            MaterialsSeeder::class,
            PaymentsSeeder::class,
            ExpeditionsSeeder::class,
            PromosSeeder::class,
            InfosSeeder::class,
            CategorysSeeder::class,
            ColorsSeeder::class,
            EstimationsSeeder::class,
            CouriersTableSeeder::class,
            LocationsTableSeeder::class,
            CustomsSeeder::class,
            OrdersSeeder::class,
            Detail_ordersSeeder::class,
            DeadlinesSeeder::class,
        ]);
    }
}
