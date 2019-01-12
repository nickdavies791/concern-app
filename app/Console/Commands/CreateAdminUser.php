<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a default admin account';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Creating user...');

        factory('App\User')->create([
            'name' => 'Admin Account',
            'role_id' => 4,
            'email' => 'admin@admin.com'
        ]);

        $this->info('Username: admin@admin.com');
        $this->info('Password: secret');
    }
}
