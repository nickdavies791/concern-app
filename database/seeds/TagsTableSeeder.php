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
            'name' => 'Domestic Abuse',
        ]);
        factory('App\Tag')->create([
            'id' => 2,
            'name' => 'Sexual Abuse',
        ]);
        factory('App\Tag')->create([
            'id' => 3,
            'name' => 'Neglect',
        ]);
        factory('App\Tag')->create([
            'id' => 4,
            'name' => 'Welfare',
        ]);
        factory('App\Tag')->create([
            'id' => 5,
            'name' => 'Physical Abuse',
        ]);
        factory('App\Tag')->create([
            'id' => 6,
            'name' => 'Emotional Abuse',
        ]);
        factory('App\Tag')->create([
            'id' => 7,
            'name' => 'Child Sexual Exploitation',
        ]);
        factory('App\Tag')->create([
            'id' => 8,
            'name' => 'Female Genital Mutilation',
        ]);
        factory('App\Tag')->create([
            'id' => 9,
            'name' => 'Bullying',
        ]);
        factory('App\Tag')->create([
            'id' => 10,
            'name' => 'Cyberbullying',
        ]);
        factory('App\Tag')->create([
            'id' => 11,
            'name' => 'Injury',
        ]);
        factory('App\Tag')->create([
            'id' => 12,
            'name' => 'Mental Health',
        ]);
        factory('App\Tag')->create([
            'id' => 13,
            'name' => 'Behaviour',
        ]);
    }
}
