<?php

use Illuminate\Database\Seeder;

class SpacesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('spaces')->insert([
            'client_id' => 1,
            'name' => 'Bar'
        ]);

        DB::table('spaces')->insert([
            'client_id' => 1,
            'name' => 'Keuken'
        ]);

        DB::table('spaces')->insert([
            'client_id' => 1,
            'name' => 'Zaal'
        ]);



        DB::table('spaces')->insert([
            'client_id' => 2,
            'name' => 'Keuken'
        ]);

        DB::table('spaces')->insert([
            'client_id' => 2,
            'name' => 'Zaal'
        ]);

        DB::table('spaces')->insert([
            'client_id' => 2,
            'name' => 'Opslagkamer'
        ]);
    }
}
