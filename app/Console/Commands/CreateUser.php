<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
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
        $data['name']     = $this->ask('What is your name?');
        $data['email']    = $this->ask('What is your email?');
        $data['is_admin'] = filter_var($this->choice('Admin user?', ['false', 'true'], 0), FILTER_VALIDATE_BOOLEAN);
        $data['password'] = Hash::make(str_random(45));

        $validator = Validator::make($data, [
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users'
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $error) {
                $this->error($error[0]);
            }

            return;
        }

        $user = User::create($data);
        event(new Registered($user));

        $this->info(sprintf('%s is created, check your email', $data['name']));
    }
}
