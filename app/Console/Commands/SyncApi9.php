<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Api;

class SyncApi9 extends Command
{
    protected $signature = 'app:sync-api9';

    protected $description = 'Synchronize between API Server 9';

    
    public function handle()
    {
        $api = Api::where('support', 'corn')->skip(8)->first();

        if($api){
            RunOrderSendingCorn($api->id);
            RunOrderGettingCorn($api->id);
            RunServiceUpdatingCorn($api->id);
        }
        
        return 0;
    }
}
