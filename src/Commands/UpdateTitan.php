<?php

namespace PbbgIo\Titan\Commands;

use Illuminate\Console\Command;

class UpdateTitan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'titan:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the titan installation';

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
        $this->call('migrate');
    }
}
