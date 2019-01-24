<?php

use App\User;
use Illuminate\Database\Seeder;

class DocumentUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::all()->each(function ($user){
            $documents = range(1, 5);
            shuffle($documents);
            $user->documents()->attach(array_slice($documents, 0, rand(1, 5)));
        });
    }
}
