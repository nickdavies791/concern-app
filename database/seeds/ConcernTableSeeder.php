<?php

use Illuminate\Database\Seeder;

class ConcernTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Concern', 500)->create();
    }
}
