<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Movement extends Command
{

    protected $signature = 'move:areas';

    protected $description = 'The areas are moved';


    public function handle()
    {
        //return Command::SUCCESS;
        $this->info("SUCCESS");
    }
}
