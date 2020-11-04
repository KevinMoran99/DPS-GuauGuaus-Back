<?php

use Illuminate\Database\Seeder;

class permissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sches = array(
            array("pets", 1, 1, 1, 1, 1),
        );
        foreach($sches as $sche){
            $array= array_values($sche);
            DB::table('permissions')->insert([
             'registro' => $array[0],
             'create'=>$array[1],
             'read'=>$array[2],
             'update'=>$array[3],
             'delete'=>$array[4],
             'users_types_id'=>$array[5]
            ]);
        }
    }
}
