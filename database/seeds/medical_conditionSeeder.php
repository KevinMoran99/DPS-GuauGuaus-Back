<?php

use Illuminate\Database\Seeder;

class medical_conditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = array('Ceguera', 'Obesidad', 'Ninguna');
        foreach($types as $type){
            DB::table('medical_condition')->insert([
             'name' => $type
            ]);
        }
    }
}
