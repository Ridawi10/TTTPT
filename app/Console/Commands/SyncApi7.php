<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Api;

class SyncApi7 extends Command
{
    protected $signature = 'app:sync-api7';

    protected $description = 'Synchronize between API Server 7';

    
    public function handle()
    {
        $api = Api::where('support', 'corn')->skip(6)->first();

        if($api){
            RunOrderSendingCorn($api->id);
            RunOrderGettingCorn($api->id);
            RunServiceUpdatingCorn($api->id);
        }
        
        return 0;
    }
}
