<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\FridayEmail;
class SendFridayEmail extends Command
{
    protected $signature = 'email:friday';
    protected $description = 'Send a Happy Friday email to all users';
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::whereNull('deleted_at')->get();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new FridayEmail($user));
        }

        $this->info('Happy Friday emails sent to all users.');
    }
}
