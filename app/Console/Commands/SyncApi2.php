<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Api;

class SyncApi2 extends Command
{
    protected $signature = 'app:sync-api2';

    protected $description = 'Synchronize between API Server 2';

    
    public function handle()
    {
        $api = Api::where('support', 'corn')->skip(1)->first();

        if($api){
            RunOrderSendingCorn($api->id);
            RunOrderGettingCorn($api->id);
            RunServiceUpdatingCorn($api->id);
        }
        
        return 0;
    }
}
