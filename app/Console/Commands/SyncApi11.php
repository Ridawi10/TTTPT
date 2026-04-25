<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Api;

class SyncApi11 extends Command
{
    protected $signature = 'app:sync-api11';

    protected $description = 'Synchronize between API Server 11';

    
    public function handle()
    {
        $api = Api::where('support', 'corn')->skip(10)->first();

        if($api){
            RunOrderSendingCorn($api->id);
            RunOrderGettingCorn($api->id);
            RunServiceUpdatingCorn($api->id);
        }
        
        return 0;
    }
}
