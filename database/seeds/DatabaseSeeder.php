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
        $this->call(SchoolsTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(StudentsTableSeeder::class);
        $this->call(AttendancesTableSeeder::class);
        $this->call(ExclusionsTableSeeder::class);
        $this->call(GroupTableSeeder::class);
        $this->call(DocumentTableSeeder::class);
        $this->call(DocumentUserTableSeeder::class);
        $this->call(GroupUserTableSeeder::class);
        $this->call(ConcernTableSeeder::class);
        $this->call(CommentTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(ConcernStudentTableSeeder::class);
        $this->call(ConcernTagTableSeeder::class);
    }
}
