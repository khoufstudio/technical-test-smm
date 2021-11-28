<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\ProductRequest;
use App\Models\ProductRequestList;

class ProductRequestController extends Controller
{
    public function index()
    {
        $productRequests = ProductRequest::with('customer')->paginate(5);

        return response()->json($productRequests);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idCustomer' => 'required',
            'orderDate' => 'required',
            'productSubmit' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json('Product Request failed!');
        }
        
        $productRequest = new ProductRequest([
            'customer_id' => $request->input('idCustomer'),
            'date_product_request' => $request->input('orderDate') 
        ]);
        $productRequest->save();

        // save product_request_list
        foreach ($request->input('productSubmit') as $productSubmit) {
            $productRequestList = new ProductRequestList([
                'product_request_id' => $productRequest->id,
                'product_id' => $productSubmit['productId'],
                'quantity' => $productSubmit['quantity'],
                'description' => $productSubmit['description'],
            ]);

            $productRequestList->save();

            // decrement stock
            $product = Product::find($productSubmit['productId']);
            $product->decrement('stock', $productSubmit['quantity']);
        } 

        return response()->json('Product Request created!');
    }

    public function destroy($id)
    {
        $productRequest = ProductRequest::find($id);
        $productRequest->delete();

        return response()->json('Product deleted!');
    }
}
