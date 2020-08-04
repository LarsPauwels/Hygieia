<?php

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
        $this->call(UserSeeder::class);
        $this->call(ClientsSeeder::class);
        $this->call(SpacesSeeder::class);
        $this->call(ProductsSeeder::class);
        $this->call(FrequencySeeder::class);
        $this->call(ProceduresSeeder::class);
        $this->call(ItemsSeeder::class);
        $this->call(ItemsSpaceSeeder::class);
    }
}
