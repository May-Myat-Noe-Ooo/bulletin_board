<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\MonthlyDashboardEmail;

class SendMonthlyDashboardData extends Command
{
    protected $signature = 'email:monthly-dashboard';
    protected $description = 'Send monthly dashboard data to admins';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $admins = User::where('type', 0)->get();

        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new MonthlyDashboardEmail($admin));
        }

        $this->info('Monthly dashboard data sent to admins.');
    }
}
