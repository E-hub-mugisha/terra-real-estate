<?php
// ─────────────────────────────────────────────────────────────────────────────
// database/seeders/AdvertisementPackageSeeder.php
// ─────────────────────────────────────────────────────────────────────────────
 
namespace Database\Seeders;
 
use App\Models\AdvertisementPackage;
use Illuminate\Database\Seeder;
 
class AdvertisementPackageSeeder extends Seeder
{
    public function run(): void
    {
        AdvertisementPackage::seedDefaults();
        $this->command->info('Advertisement packages seeded (Basic, Standard, Premium).');
    }
}