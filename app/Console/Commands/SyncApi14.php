<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Api;

class SyncApi14 extends Command
{
    protected $signature = 'app:sync-api14';

    protected $description = 'Synchronize between API Server 14';

    
    public function handle()
    {
        $api = Api::where('support', 'corn')->skip(13)->first();

        if($api){
            RunOrderSendingCorn($api->id);
            RunOrderGettingCorn($api->id);
            RunServiceUpdatingCorn($api->id);
        }
        
        return 0;
    }
}
