<?php

use Illuminate\Database\Seeder;

class ProceduresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('procedures')->insert([
            'name' => 'schrobben',
            'description' => 'Grondig schrobben met een schuursponsje en zeepsop. Nadien met nat overgaan.'
        ]);

        DB::table('procedures')->insert([
            'name' => 'ijskasten en vriezers',
            'description' => 'Eerst helemaal leegmaken en met een natte doek (en zeepsop) de wanden, onderkant en 
            bovenkant grondig kusien. Nadien met een handdoek afdrogen.'
        ]);

        DB::table('procedures')->insert([
            'name' => 'mixers en glaswerk',
            'description' => 'Grondig volledig afwassen in een vaatwas, of in water met zeepsop.'
        ]);

        DB::table('procedures')->insert([
            'name' => 'koffiezet',
            'description' => 'Toestel uitschakelen, koffiepulp bij het groenafval gooien. Opvanglade en rooster kuisen
            met water en zeepsop (niet schuren). Melkslangetje afkuisen met een vochtige, propere doek. Melker laten
            uitspoelen met spoelproduct. Toestel in reinigings-optie zetten, tablet inwerpen en laten doorlopen met water.'
        ]);
    }
}
