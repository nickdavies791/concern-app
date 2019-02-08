<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InitialSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'concerns:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set up the application';

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
        $this->info('Setting up, please wait...');
        \Artisan::call('migrate:fresh');
        \Artisan::call('admin:create');
        \Artisan::call('roles:create');
        \Artisan::call('tags:create');
        \Artisan::call('groups:create');
        $this->info('Setup complete!');
        $this->info('Username: admin@admin.com');
        $this->info('Password: secret');
    }
}
