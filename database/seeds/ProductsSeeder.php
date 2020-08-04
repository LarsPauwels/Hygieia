<?php

use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'user_id' => 1,
            'name' => 'Dreft',
            'quantity' => '1 dopje'
        ]);

        DB::table('products')->insert([
            'user_id' => 1,
            'name' => 'KenoLUX Rinse',
            'quantity' => '25 centiliter'
        ]);

        DB::table('products')->insert([
            'user_id' => 1,
            'name' => 'ontkalktabletten',
            'quantity' => '1 tablet'
        ]);
    }
}
