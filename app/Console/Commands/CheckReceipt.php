<?php

namespace App\Console\Commands;

use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckReceipt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zz-my-tasks:check-receipt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks the mobile clients market(Android, Ios) receipts';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //android ve iphone kullanicilarinin receiptlerine bakip
        //subscriptioni cancel olmus olan var mi ona bakacagim...
        /** @var Client[] $clientSet */
        $clientSet = Client::where('SubscriptionChecked',0)
            ->where('PaidUntil', '>', Carbon::today()->subDays(-3))
            ->where('PaidUntil', '<', Carbon::today()->addDays(1))
            ->where('SubscriptionChecked', '<', 4)
            ->get();

        foreach ($clientSet as $client) {
            $client->CheckReceiptCLI();
        }
    }
}
