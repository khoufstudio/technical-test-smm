<?php

namespace App\Repository\Product;
use App\Models\Product;
use Illuminate\Http\Request;

class EloquentProductRepository implements ProductRepository
{
    public function getProducts()
    {
        return Product::select('id', 'name', 'detail')->get();
    }
    
    //public function getProductById($id)
    //{
        //return Product::select('id', 'name', 'detail')->whereId($id)->first();
    //}
}

