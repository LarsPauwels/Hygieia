<?php

use Illuminate\Database\Seeder;

class ClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clients')->insert([
            'user_id' => 1,
            'name' => 'Café X',
            'address' => "Iksstraat 78",
            'email' => "info@x.be",
        ]);

        DB::table('clients')->insert([
            'user_id' => 1,
            'name' => 'Restaurant Chez Guevara',
            'address' => "La Higuera 9",
            'email' => "ernesto@guevara.ar",
        ]);
    }
}
