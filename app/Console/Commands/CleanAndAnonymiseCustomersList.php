<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Jobs\CustomerJob;
use Illuminate\Console\Command;

class CleanAndAnonymiseCustomersList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:customers:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove customers with no activity (no visit) > 6 months and anonymise customers data deleted > 1 month';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        CustomerJob::dispatch()->onQueue('default'); 
        $this->info('Success !'); 
    }
}
