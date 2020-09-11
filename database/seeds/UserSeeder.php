<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Hygieia',
            'email' => 'info@hygieia.be',
            'role_id' => 1,
            'password' => bcrypt('HygieiaPassword'),
        ]);
    }
}
