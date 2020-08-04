<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $role1 = new \App\Role();
        $role1->name = 'admin';
        $role1->description = 'Administrator account';
        $role1->save();

        $role2 = new \App\Role();
        $role2->name = 'company';
        $role2->description = 'Account van een klant';
        $role2->save();
    }
}