<?php

namespace App\Console\Commands;

use App\Models\ProductAuction;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckAuctionStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-auction-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status of auctions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ProductAuction::where('end', '<', Carbon::now())
            ->whereNotIn('status', ['sold', 'ended'])
            ->update(['status' => 'ended']);

        $this->info('Auction statuses updated.');
    }
}
