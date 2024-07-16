<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;

class DeleteOldPasswordResets extends Command
{
    protected $signature = 'passwordresets:delete-old';
    protected $description = 'Delete password reset entries older than a week';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $weekAgo = Carbon::now()->subWeek();
        DB::table('password_resets')->where('created_at', '<', $weekAgo)->delete();

        $this->info('Old password reset entries deleted.');
    }
}
