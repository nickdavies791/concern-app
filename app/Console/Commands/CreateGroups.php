<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateGroups extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'groups:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the groups in the database';

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
        $this->info('Creating groups...');
        \Artisan::call('db:seed', array('--class' => 'GroupTableSeeder'));
        $this->info('Groups created!');
    }
}
