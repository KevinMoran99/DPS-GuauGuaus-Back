<?php

use Illuminate\Database\Seeder;

class usersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = array(
            array('Jorge','Shafick HANDAL', 'miguelf@gamil.com', "123455", '12345697-7', "mi casa", '77889776', 1, 1),
        );
        foreach($users as $user){
            $array= array_values($user);
            DB::table('users')->insert([
             'name' => $array[0],
             'lastname'=>$array[1],
             'email'=>$array[2],
             'password'=>$array[3],
             'dui'=>$array[4],
             'address'=>$array[5],
             'phone'=>$array[6],
             'state'=>$array[7],
             'type_user_id'=>$array[8]
            ]);
        }
    }
}
