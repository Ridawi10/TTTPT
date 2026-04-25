<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Api;

use Illuminate\Support\Facades\Log;

class SyncApi1 extends Command
{
   
    protected $signature = 'app:sync-api1';

    protected $description = 'Synchronize between API Server 1';

    
    public function handle()
    {
        $api = Api::where('support', 'corn')->first();

        if($api){
            RunOrderSendingCorn($api->id);
            RunOrderGettingCorn($api->id);
            RunServiceUpdatingCorn($api->id);
        }
        
        return 0;
    }
}
