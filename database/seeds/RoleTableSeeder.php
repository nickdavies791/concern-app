<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Role')->create([
            'id' => 1,
            'type' => 'User',
        ]);
        factory('App\Role')->create([
            'id' => 2,
            'type' => 'Staff',
        ]);
        factory('App\Role')->create([
            'id' => 3,
            'type' => 'Safeguarding',
        ]);
        factory('App\Role')->create([
            'id' => 4,
            'type' => 'Admin',
        ]);
    }
}
