<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(\Encore\Admin\Auth\Database\AdminTablesSeeder::class);
        $this->call(AdminMenuTableSeeder::class);

        $this->call(ProductsSeeder::class);
    }
}
