<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Api;

class SyncApi4 extends Command
{
    protected $signature = 'app:sync-api4';

    protected $description = 'Synchronize between API Server 4';

    
    public function handle()
    {
        $api = Api::where('support', 'corn')->skip(3)->first();

        if($api){
            RunOrderSendingCorn($api->id);
            RunOrderGettingCorn($api->id);
            RunServiceUpdatingCorn($api->id);
        }
        
        return 0;
    }
}
