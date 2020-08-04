<?php

use Illuminate\Database\Seeder;

class ItemsSpaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('item_product')->insert([
            'item_id' => 2,
            'product_id' => 1
        ]);

        DB::table('item_product')->insert([
            'item_id' => 2,
            'product_id' => 2
        ]);

        DB::table('item_product')->insert([
            'item_id' => 2,
            'product_id' => 3
        ]);

        DB::table('item_product')->insert([
            'item_id' => 1,
            'product_id' => 1
        ]);

        DB::table('item_product')->insert([
            'item_id' => 3,
            'product_id' => 1
        ]);

        DB::table('item_product')->insert([
            'item_id' => 4,
            'product_id' => 1
        ]);

        DB::table('item_product')->insert([
            'item_id' => 5,
            'product_id' => 1
        ]);
    }
}
