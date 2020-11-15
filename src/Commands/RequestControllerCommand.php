<?php

namespace Lorisleiva\RequestController\Commands;

use Illuminate\Console\Command;

class RequestControllerCommand extends Command
{
    public $signature = 'request-controller';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
