<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CustomerResource;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Http\Requests\CommercialMessageRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CustomerController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function get()
    {
        return Customer::get();
    }


    /**
     * API : Expose all customers data 
     */
    public function getAll()
    {
        $customers = CustomerResource::collection(Customer::all());
        return $customers;
    }


    /** 
     * Change customers' table optin value
     */
    public function acceptCommercialMessage(CommercialMessageRequest $request, $id)
    {
        $acceptMessage = $request->message;

        try{
            $customer = Customer::findOrFail($id);
        }
        catch(ModelNotFoundException $e){
            return response()->json(['message' => 'No change applied : ' . $e->getMessage() . '. Check if model is deleted.']);
        }
     
        $customer->update(['has_optin' => $acceptMessage]);

        return response()->json(['message' => 'Receiving commercial message params updated.']);
    }


    /** 
     * Test - for soft deleting customers data
     */
    public function softDelete(Request $request, $id)
    {
        try{
            $customer = Customer::findOrFail($id);
        }
        catch(ModelNotFoundException $e){
            return response()->json(['message' => 'No change applied : ' . $e->getMessage() . '. Check if model is already deleted.']);
        }

        $customer->delete();
        return response()->json(['message' => 'Customer deleted']);
    }

    
    /**
     * API : Expose customers visits data for each store
     */
    public function getOneCustomerStoreVisitsData()
    {
        $rawRequest='select c.first_name as name, s.name as store, count(v.created_at) as visits, min(v.created_at) as first_visit, max(v.created_at) as last_visit from visits as v inner join customers as c on c.id=v.customer_id inner join stores as s on s.id=v.store_id group by c.id';

        $customerVisits = DB::select(DB::raw($rawRequest));

        File::put('./requests.sql', $rawRequest);

        return response()->json($customerVisits);
    }
}
