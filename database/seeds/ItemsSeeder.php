<?php

use Illuminate\Database\Seeder;

class ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            'space_id' => 1,
            'name' => 'IJskasten',
            'frequency_id' => 5,
            'procedure_id' => 2
        ]);

        DB::table('items')->insert([
            'space_id' => 1,
            'name' => 'Koffiezet',
            'frequency_id' => 1,
            'procedure_id' => 4
        ]);

        DB::table('items')->insert([
            'space_id' => 1,
            'name' => 'Toog',
            'frequency_id' => 2,
            'procedure_id' => 1
        ]);

        DB::table('items')->insert([
            'space_id' => 2,
            'name' => 'Diepvries',
            'frequency_id' => 5,
            'procedure_id' => 2
        ]);

        DB::table('items')->insert([
            'space_id' => 2,
            'name' => 'Mixer',
            'frequency_id' => 7,
            'procedure_id' => 3
        ]);

        DB::table('items')->insert([
            'space_id' => 4,
            'name' => 'IJskasten',
            'frequency_id' => 5,
            'procedure_id' => 2
        ]);

        DB::table('items')->insert([
            'space_id' => 4,
            'name' => 'Koffiezet',
            'frequency_id' => 1,
            'procedure_id' => 4
        ]);

        DB::table('items')->insert([
            'space_id' => 6,
            'name' => 'Diepvries',
            'frequency_id' => 5,
            'procedure_id' => 2
        ]);

        DB::table('items')->insert([
            'space_id' => 4,
            'name' => 'Mixer',
            'frequency_id' => 7,
            'procedure_id' => 3
        ]);
    }
}
