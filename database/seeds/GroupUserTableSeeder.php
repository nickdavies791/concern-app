<?php

use App\User;
use Illuminate\Database\Seeder;

class GroupUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::all()->each(function ($user){
            //Policy seeder makes 5 policies
            $groups = range(1, 5);
            //shuffle array to get random order;
            shuffle($groups);
            //attach random policies to each user
            $user->groups()->attach(array_slice($groups, 0, rand(1, 5)));
        });
    }
}
