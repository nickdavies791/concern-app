<?php

use Illuminate\Database\Seeder;

class ExclusionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Exclusion', 25)->create();
    }
}
