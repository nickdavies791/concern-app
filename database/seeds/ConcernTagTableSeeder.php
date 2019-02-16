<?php

use App\Concern;
use Illuminate\Database\Seeder;

class ConcernTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Concern::all()->each(function ($concern){
            $tags = range(1, 13);
            shuffle($tags);
            $concern->tags()->attach(array_slice($tags, 0, rand(1, 3)));
        });
    }
}
