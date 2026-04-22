<?php

namespace App\Console\Commands;
 
use App\Models\Advertisement;
use App\Models\TerraAdvertisement;
use Illuminate\Console\Command;
 
class ExpireAdvertisements extends Command
{
    protected $signature   = 'ads:expire';
    protected $description = 'Mark active advertisements as expired when past their end date.';
 
    public function handle(): void
    {
        $count = TerraAdvertisement::where('status', 'active')
            ->where('expires_at', '<', now())
            ->update(['status' => 'expired']);
 
        $this->info("Expired {$count} advertisement(s).");
    }
}
 