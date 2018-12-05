<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\User')->create([
            'name' => 'Matt Tonks',
            'role_id' => 3,
            'email' => 'matt.tonks@heathpark.net'
        ]);
        factory('App\User')->create([
            'name' => 'Nick Davies',
            'role_id' => 3,
            'email' => 'nick.davies@clpt.co.uk'
        ]);

        factory('App\User', 3)->create();
    }
}
