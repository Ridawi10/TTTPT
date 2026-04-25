<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Api;

class SyncApi10 extends Command
{
    protected $signature = 'app:sync-api10';

    protected $description = 'Synchronize between API Server 10';

    
    public function handle()
    {
        $api = Api::where('support', 'corn')->skip(9)->first();

        if($api){
            RunOrderSendingCorn($api->id);
            RunOrderGettingCorn($api->id);
            RunServiceUpdatingCorn($api->id);
        }
        
        return 0;
    }
}
