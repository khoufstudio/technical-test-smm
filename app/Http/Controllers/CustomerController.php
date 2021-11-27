<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    /*
     * search by nik
    */
    public function nik($nik)
    {
        $result = Customer::where('nik', 'LIKE', '%'. $nik. '%')->get();

        if(count($result)){
            return Response()->json($result);
        } else {
            return response()->json(['Result' => 'No Data not found'], 404); 
        }
    }
}
