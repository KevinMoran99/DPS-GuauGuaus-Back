<?php

use Illuminate\Database\Seeder;

class petsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pets = array(
            array('Hunter', "2013/8/16", "url", 8.92, 9.12, 1, 2, 1),
        );
        foreach($pets as $pet){
            $array= array_values($pet);
            DB::table('pets')->insert([
             'name' => $array[0],
             'birthday'=>$array[1],
             'photo'=>$array[2],
             'weight'=>$array[3],
             'height'=>$array[4],
             'state'=>$array[5],
             'species_id'=>$array[6],
             'owner_id'=>$array[7]
            ]);
        }
    }
}
