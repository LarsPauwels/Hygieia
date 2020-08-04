<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Client;
use Carbon\Carbon;
use App\Http\Helpers\MailHelper;
use  App\Http\Controllers\ClientController;

class PaymentCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Payment:end';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email to user about the end of a contract.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $now = date("Y-m-d H:i:s", strtotime(Carbon::now()->addWeek()));

        $clients = Client::get();
        if($clients !== null){
            $clients->where('expire_payment', '<=', $now)->where('expire_payment', '!=', null)->each(function($client) {
                $date = Carbon::parse($client->expire_payment);
                $now = Carbon::now();

                if ($now >= $date) {
                    $clientController = new ClientController();
                    $clientController->updateClientExpire($client->id);
                    MailHelper::accountRemove($client);
                } else {
                    $days = $date->diffInDays($now);
                    MailHelper::accountExpired($client, $days);
                }
            });
        }
    }
}
