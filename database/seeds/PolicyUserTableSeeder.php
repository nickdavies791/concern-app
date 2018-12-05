<?php

use App\User;
use Illuminate\Database\Seeder;

class PolicyUserTableSeeder extends Seeder
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
            $policies = range(1, 5);
            //shuffle array to get random order;
            shuffle($policies);
            //attach random policies to each user
            $user->policies()->attach(array_slice($policies, 0, rand(1, 5)));
        });
    }
}
