<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;


class JustTestingScheduler extends Command
{
    protected $signature = 'test:scheduler';
    protected $description = 'Test scheduler runs every 2 seconds';

    public function __invoke()
    {
        Log::info("Scheduler test is running at ". now());
        echo "Scheduler test is running at " .now() .PHP_EOL;
    }
}
