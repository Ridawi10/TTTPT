<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Api;

class SyncApi13 extends Command
{
    protected $signature = 'app:sync-api13';

    protected $description = 'Synchronize between API Server 13';

    
    public function handle()
    {
        $api = Api::where('support', 'corn')->skip(12)->first();

        if($api){
            RunOrderSendingCorn($api->id);
            RunOrderGettingCorn($api->id);
            RunServiceUpdatingCorn($api->id);
        }
        
        return 0;
    }
}
