<?php

use Illuminate\Database\Seeder;

class FrequencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('frequencies')->insert([
            'name' => 'dagelijks'
        ]);

        DB::table('frequencies')->insert([
            'name' => '2x per dag'
        ]);

        DB::table('frequencies')->insert([
            'name' => '1x per week'
        ]);

        DB::table('frequencies')->insert([
            'name' => '2x per week'
        ]);

        DB::table('frequencies')->insert([
            'name' => '3x per week'
        ]);

        DB::table('frequencies')->insert([
            'name' => 'wekelijks'
        ]);

        DB::table('frequencies')->insert([
            'name' => 'na gebruik'
        ]);
    }
}
