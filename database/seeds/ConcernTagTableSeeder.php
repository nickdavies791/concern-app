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
            //Policy seeder makes 5 policies
            $tags = range(1, 5);
            //shuffle array to get random order;
            shuffle($tags);
            //attach random policies to each user
            $concern->tags()->attach(array_slice($tags, 0, rand(1, 6)));
        });
    }
}
