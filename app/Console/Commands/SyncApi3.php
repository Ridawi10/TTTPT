<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Api;

class SyncApi3 extends Command
{
    protected $signature = 'app:sync-api3';

    protected $description = 'Synchronize between API Server 3';

    
    public function handle()
    {
        $api = Api::where('support', 'corn')->skip(2)->first();

        if($api){
            RunOrderSendingCorn($api->id);
            RunOrderGettingCorn($api->id);
            RunServiceUpdatingCorn($api->id);
        }
        
        return 0;
    }
}
