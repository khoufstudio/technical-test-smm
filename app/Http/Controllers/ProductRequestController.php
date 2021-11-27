<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductRequest;

class ProductRequestController extends Controller
{
    public function index()
    {
        $productRequests = ProductRequest::with('customer')->paginate(10);

        return response()->json($productRequests);
    }

    public function destroy($id) {
        $productRequest = ProductRequest::find($id);
        $productRequest->delete();

        return response()->json('Product deleted!');
    }
}
