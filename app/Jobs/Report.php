<?php

namespace App\Jobs;

use App\Models\User;
use App\Mail\DailyReportMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class Report implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $users = User::all();

    
        if ($users->count() > 0) {
            foreach ($users as $user) {
                // Mail::to($user->email)->send(new DailyReportMail($user));
                Log::info($user);
            }
        }
        return 0;
    }
}
