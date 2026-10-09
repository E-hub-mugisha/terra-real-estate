<?php

namespace App\Console\Commands;

use App\Models\Lease;
use App\Services\RentInvoiceService;
use Illuminate\Console\Command;

class GenerateRecurringRentInvoices extends Command
{
    protected $signature = 'rent:generate-recurring-invoices';

    protected $description = 'Generate recurring rent invoices for active leases';

    public function handle(RentInvoiceService $invoiceService): int
    {
        $generated = 0;

        Lease::query()
            ->where('status', 'active')
            ->whereDate('start_date', '<=', today())
            ->whereDate('end_date', '>=', today())
            ->orderBy('id')
            ->chunkById(100, function ($leases) use (
                $invoiceService,
                &$generated
            ) {
                foreach ($leases as $lease) {
                    $generated += $invoiceService
                        ->generateRecurringInvoices($lease);
                }
            });

        $this->info(
            "Generated {$generated} recurring rent invoice(s)."
        );

        return self::SUCCESS;
    }
}