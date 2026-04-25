<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Api;

class SyncApi15 extends Command
{
    protected $signature = 'app:sync-api15';

    protected $description = 'Synchronize between API Server 15';

    
    public function handle()
    {
        $api = Api::where('support', 'corn')->skip(14)->first();

        if($api){
            RunOrderSendingCorn($api->id);
            RunOrderGettingCorn($api->id);
            RunServiceUpdatingCorn($api->id);
        }
        
        return 0;
    }
}
