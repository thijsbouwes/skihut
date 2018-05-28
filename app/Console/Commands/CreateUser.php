<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new user';

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
        $user = new User;

        $user->name = $this->ask('What is your name?');
        $user->email = $this->ask('What is your email?');
        $user->is_admin = filter_var($this->choice('Admin user?', ['false', 'true'], 0), FILTER_VALIDATE_BOOLEAN);
        $user->password = Hash::make(str_random(45));

        Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|unique'
        ]);

        $user->save();
        $this->info(sprintf('%s is created, with password: ', $user->name, $user->password));
    }
}
