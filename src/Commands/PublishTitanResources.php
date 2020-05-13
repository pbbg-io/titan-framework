<?php

namespace PbbgIo\Titan\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class PublishTitanResources extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'titan:resources';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish Titans resources';

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
            \Artisan::call('vendor:publish', [
                '--force'   =>  true,
                '--tag'    =>  'titan'
            ]);

            if(\File::copyDirectory(dirname(dirname(__DIR__)) . '/themes', storage_path('themes')))
            {
                \Artisan::call('theme:install',  [
                    'package' => 'Default'
                ]);
                \Artisan::call('theme:install',  [
                    'package' => 'Admin'
                ]);
            }

        }
}
