<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateTags extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tags:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the tags in the database';

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
        $this->info('Creating tags...');
        \Artisan::call('db:seed', array('--class' => 'TagsTableSeeder'));
        $this->info('Tags created!');
    }
}
