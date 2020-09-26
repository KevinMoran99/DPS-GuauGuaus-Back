<?php

use Illuminate\Database\Seeder;

class pet_detailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $details = array(
            array(1, 2, "tiene sobrepeso"),
            array(1, 1, "y ta ciego")
        );
        foreach($details as $detail){
            $array= array_values($detail);
            DB::table('pet_details')->insert([
             'pet_id' => $array[0],
             'codition_id'=>$array[1],
             'observations'=>$array[2],
            ]);
        }
    }
}
