<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:testing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testing Command';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Log::info("Testing With Scheduler");
    }
}
