<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRequest extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id', 'date_product_request'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getDateProductRequestAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }
}
