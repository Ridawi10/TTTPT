<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Api;

class SyncApi8 extends Command
{
    protected $signature = 'app:sync-api8';

    protected $description = 'Synchronize between API Server 8';

    
    public function handle()
    {
        $api = Api::where('support', 'corn')->skip(7)->first();

        if($api){
            RunOrderSendingCorn($api->id);
            RunOrderGettingCorn($api->id);
            RunServiceUpdatingCorn($api->id);
        }
        
        return 0;
    }
}
