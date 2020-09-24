<?php

use Illuminate\Database\Seeder;

class speciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $species = array('Mamifero', 'Ave', 'Reptil', 'Anfibio', 'Pez', 'Agnato', 'Insecto', 'Arácnido', 'Crustáceo', 'Molusco', 'Otro');
        foreach($species as $specie){
            DB::table('species')->insert([
             'name' => $specie
            ]);
        }
    }
}
