<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductRequest;

class ProductRequestController extends Controller
{
    public function index()
    {
        $productRequests = ProductRequest::with('customer')->paginate(5);

        return response()->json($productRequests);
    }

    public function store(Request $request)
    {
        $productRequest = new ProductRequest([
            'customer_id' => $request->input('idCustomer'),
            'date_product_request' => $request->input('orderDate') 
        ]);
        $productRequest->save();

        return response()->json('Product Request created!');
    }

    public function destroy($id)
    {
        $productRequest = ProductRequest::find($id);
        $productRequest->delete();

        return response()->json('Product deleted!');
    }
}
