<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(StudentsTableSeeder::class);
        $this->call(GroupTableSeeder::class);
        $this->call(PolicyTableSeeder::class);
        $this->call(PolicyUserTableSeeder::class);
        $this->call(GroupUserTableSeeder::class);
        $this->call(ConcernTableSeeder::class);
        $this->call(CommentTableSeeder::class);
    }
}
