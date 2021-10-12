<?php

namespace App\Jobs;

use App\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class DeleteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Delete job where seen_until date is greater than now
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $count = Job::where('seen_until', '>', date('Y-m-d'))->delete();
        Log::info("$count jobs deleted");
    }
}
