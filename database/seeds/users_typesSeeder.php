<?php

use Illuminate\Database\Seeder;

class users_typesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $types = array('Doctor', 'Secretaria', 'Cliente');
       foreach($types as $type){
           DB::table('users_types')->insert([
            'name' => $type
           ]);
       }
    }
}
