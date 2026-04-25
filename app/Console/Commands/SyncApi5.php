<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Api;

class SyncApi5 extends Command
{
    protected $signature = 'app:sync-api5';

    protected $description = 'Synchronize between API Server 5';

    
    public function handle()
    {
        $api = Api::where('support', 'corn')->skip(4)->first();

        if($api){
            RunOrderSendingCorn($api->id);
            RunOrderGettingCorn($api->id);
            RunServiceUpdatingCorn($api->id);
        }
        
        return 0;
    }
}
