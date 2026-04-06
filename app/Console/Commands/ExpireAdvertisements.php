<?php

namespace App\Console\Commands;
 
use App\Models\Advertisement;
use Illuminate\Console\Command;
 
class ExpireAdvertisements extends Command
{
    protected $signature   = 'ads:expire';
    protected $description = 'Mark active advertisements as expired when past their end date.';
 
    public function handle(): void
    {
        $count = Advertisement::where('status', 'active')
            ->where('expires_at', '<', now())
            ->update(['status' => 'expired']);
 
        $this->info("Expired {$count} advertisement(s).");
    }
}
 