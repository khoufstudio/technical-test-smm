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
}
