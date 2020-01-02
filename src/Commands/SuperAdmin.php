<?php

namespace PbbgIo\Titan\Commands;

use App\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class SuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'titan:super-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign super admin';

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
        if($answer = $this->ask("Enter the user id or name to promote to super admin"))
        {
            $isInt = filter_var($answer, FILTER_VALIDATE_INT);

            if($isInt)
                $user = User::find($isInt);
            else
                $user = User::whereName($answer)->first();

            if(!$user)
                return $this->error("Invalid user");

            $user->assignRole(Role::whereName('Super Admin')->first());

            $this->info("{$user->name} assigned role of super admin");
        }
    }
}
