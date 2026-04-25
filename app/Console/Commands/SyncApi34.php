<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Api;


class SyncApi34 extends Command
{
    protected $signature = 'app:sync-api34';

    protected $description = 'Synchronize between API Server';

    
    public function handle()
    {
        $api = Api::where('support', 'corn')->skip(33)->first();

        if($api){
            RunOrderSendingCorn($api->id);
            RunOrderGettingCorn($api->id);
            RunServiceUpdatingCorn($api->id);
        }
        
        return 0;
    }
}
