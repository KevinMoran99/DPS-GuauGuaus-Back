<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('users_typesSeeder');
        $this->call('speciesSeeder');
        $this->call('appointment_typesSeeder');
        $this->call('usersSeeder');
        $this->call('petsSeeder');
        $this->call('medical_conditionSeeder');
        $this->call('permissionsSeeder');
        $this->call('schedulesSeeder');
        $this->call('specialSeeder');
        $this->call('appointmentsSeeder');
        $this->call('pet_detailsSeeder');
    }
}
