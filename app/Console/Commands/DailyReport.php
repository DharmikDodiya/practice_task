<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\DailyReportMail;

class DailyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Respectively send an exclusive Report to everyone daily via email.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();

    
        if ($users->count() > 0) {
            foreach ($users as $user) {
                Mail::to($user->email)->send(new DailyReportMail($user));
            }
        }
        return 0;
    }
}
