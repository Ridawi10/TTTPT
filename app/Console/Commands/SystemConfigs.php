<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SystemConfigs extends Command
{
    
    protected $signature = 'app:system-configs';


    protected $description = 'Command description';

  
    public function handle()
    {
        RunSystemCorn();
        
        return 0;
    }
}
