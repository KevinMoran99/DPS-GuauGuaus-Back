<?php

use Illuminate\Database\Seeder;

class appointment_typesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = array(
            array('Rutina', 1),
            array('Cirujia', 1),
            array('Vacunacion', 1),
            array('Emergencia', 24)
        );
        foreach($types as $type){
            $array= array_values($type);
            DB::table('appointment_types')->insert([
             'name' => $array[0],
             'duration'=>$array[1]
            ]);
        }
    }
}
