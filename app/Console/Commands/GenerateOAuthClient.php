<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateOAuthClient extends Command
{
    protected $signature = 'auth:generate';

    protected $description = 'Generate OAuth Client Details. NOTE: Does not insert into db right now! OUTPUT ONLY.';

    public function handle()
    {
        $this->info("");
        $this->comment("Note: This is not inserting this information into the database yet. Right now, this is just a generator; you have to copy and paste it into the db table.");
        $this->info("");
        $this->info("OAUTH CLIENT ID: " . bin2hex(openssl_random_pseudo_bytes(16)));
        $this->info("OAUTH CLIENT SECRET: " . bin2hex(openssl_random_pseudo_bytes(16)));
    }
}
