<?php

namespace App\Jobs;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CustomerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->deleteCustomersWithNoActivity();
        $this->anonimyzeCustomers();
    }


    public function deleteCustomersWithNoActivity()
    {
        $customers = Customer::with('visits')->get();

        foreach ($customers as $customer) {
            $lastVisit = $customer->visits->max('created_at')->format('Y-m-d');

            if ($lastVisit < now()->subMonths(6)->format('Y-m-d')) {
                $customer->delete();
            }
        }
    }

    public function anonimyzeCustomers(){
        $sofDeletedCustomersOneMonth = Customer::onlyTrashed()
            ->where('customers.deleted_at', '<=', now()->subMonths(1))
            ->get();

        foreach ($sofDeletedCustomersOneMonth as $customer) {
            $customer->first_name = "anonymised";
            $customer->phone = "anonymised";
            $customer->email = "anonymised";
            $customer->save();
        }
    }
}
