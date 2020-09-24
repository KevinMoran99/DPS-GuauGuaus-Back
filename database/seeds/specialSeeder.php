<?php

use Illuminate\Database\Seeder;

class specialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sches = array(
            array(1, '2020/8/1', '7:00:00', '14:00:00', 1),
        );
        foreach($sches as $sche){
            $array= array_values($sche);
            DB::table('special')->insert([
             'doctor_id' => $array[0],
             'day'=>$array[1],
             'start_hour'=>$array[2],
             'finish_hour'=>$array[3],
             'state'=>$array[4]
            ]);
        }
    }
}
