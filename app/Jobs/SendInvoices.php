<?php

namespace App\Jobs;

use App\Models\User;
use App\Mail\UserEventInvoice;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendInvoices implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::whereHas('events', function($query) {
            $query->where('payed', '=', false);
        })->get();

        foreach ($users as $user) {
            $events = $user->events()->wherePivot('payed', '=', false)->get();
            Mail::to($user)->send(new UserEventInvoice($user, $events));
        }
    }
}
