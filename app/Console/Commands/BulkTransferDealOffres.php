<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DealOffre;
use App\Models\Client;
use Illuminate\Support\Facades\DB;

class BulkTransferDealOffres extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deals:bulk-transfer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transfers completed deal offers to the historical table';

    /**
     * Execute the console command.
     *
     * @return int
     */
public function handle()
{
    DB::beginTransaction();

    try {
        // Fetch all DealOffres eligible for transfer
        $completedOffres = DealOffre::where('statut', 'completed')->get();

        foreach ($completedOffres as $offre) {
            // Check if objectives are achieved
            if ($offre->isObjectiveCompleted()) {
                // Move the offer to historique
                $offre->moveToHistorical();

                // Update the client's cagnotte balance
                $client = $offre->client;
                if ($client) {
                    $client->increment('cagnotte_balance', $offre->amount_earned_total);
                }

                $this->info("DealOffre ID {$offre->ID_deal_offre} successfully transferred.");
            } else {
                $this->warn("DealOffre ID {$offre->ID_deal_offre} objectives not completed.");
            }
        }

        DB::commit();
        $this->info('Bulk transfer completed successfully.');

    } catch (\Exception $e) {
        DB::rollBack();
        $this->error('An error occurred: ' . $e->getMessage());
    }

    return 0;
}

}
