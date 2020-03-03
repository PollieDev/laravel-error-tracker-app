<?php

namespace App\Console\Commands;

use App\Role;
use App\User;
use Illuminate\Console\Command;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates an admin user that will have access to everything.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        User::create([
            "name" => "New admin",
            "email" => $this->argument('email'),
            "password" => bcrypt($this->argument('password')),
            "role_id" => Role::$ADMIN
        ]);

        $this->info('Admin has been created.');
    }
}
