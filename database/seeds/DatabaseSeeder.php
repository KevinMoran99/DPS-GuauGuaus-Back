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
    }
}
