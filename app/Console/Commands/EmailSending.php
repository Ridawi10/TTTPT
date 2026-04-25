<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class EmailSending extends Command
{
    protected $signature = 'app:email-sending';

    protected $description = 'Send Schedule Emails';

    
    public function handle()
    {
        RunEmailSendingCorn();
        
        return 0;
    }
}
