<?php

namespace App\Console\Commands;

use App\Models\JobListing;
use Illuminate\Console\Command;

class ExpireJobListings extends Command
{
    protected $signature   = 'jobs:expire';
    protected $description = 'Expire job listings that have passed their expiry date';

    public function handle(): void
    {
        $expired = JobListing::where('status', 'active')
            ->where('expires_at', '<=', now())
            ->get();

        $count = $expired->count();

        $expired->each->expire();

        $this->info("Expired {$count} job listing(s).");
    }
}