<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\DailyPostsReport;
use App\Models\Post;
use App\Models\User;

class SendDailyPostsReport extends Command
{
   /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:daily-posts-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily report of active posts to admins';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $yesterday = now()->subDay()->toDateString();
       // dd($yesterday);
       $posts = Post::where('status', 1)
       ->whereDate('created_at', $yesterday)
       ->latest()
       ->take(10)
       ->get();
        //dd($posts);
        $admins = User::where('type', '0')->get();
        
        //dd($admins);
        //$this->info($posts);
        //$this->info($admins);
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new DailyPostsReport($posts));
        }

        $this->info('Daily posts report sent to admins.');
        return 0;
    }
}
