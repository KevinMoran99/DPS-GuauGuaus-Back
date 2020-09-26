<?php

use Illuminate\Database\Seeder;

class appointmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $appoins = array(
            array("2020/1/18 7:00:00", 'Activo', 'oh no casi', 0, 1, 1, 1, 1),
        );
        foreach($appoins as $appoin){
            $array= array_values($appoin);
            DB::table('appointments')->insert([
             'appointment_date' => $array[0],
             'status'=>$array[1],
             'observations'=>$array[2],
             'emergency'=>$array[3],
             'state'=>$array[4],
             'type_id'=>$array[5],
             'pet_id'=>$array[6],
             'doctor_id'=>$array[7]
            ]);
        }
    }
}
