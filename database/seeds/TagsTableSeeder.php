<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Tag')->create([
            'id' => 1,
            'name' => 'Bullying',
        ]);
        factory('App\Tag')->create([
            'id' => 2,
            'name' => 'Mental Health',
        ]);
        factory('App\Tag')->create([
            'id' => 3,
            'name' => 'Neglect',
        ]);
        factory('App\Tag')->create([
            'id' => 4,
            'name' => 'Suicidal Thoughts',
        ]);
        factory('App\Tag')->create([
            'id' => 5,
            'name' => 'Violence',
        ]);
    }
}
