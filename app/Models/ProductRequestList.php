<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRequestList extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'product_request_id','quantity', 'description'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
