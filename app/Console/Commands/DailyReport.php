<?php

namespace App\Console\Commands;

use App\Jobs\Report;
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
        $usersmail = User::select('email')->get();
        $emails =[];
    
       
            foreach ($usersmail as $email) {
                $emails[] = $email['email']; 
            }
            Mail::send('dailyreport',[],function($message) use ($emails){
                $message->to($emails)->subject('this is test for cron job daily report');
            });
        
    }
}
