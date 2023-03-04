<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartProducts extends Model
{
    use HasFactory;

    protected $table = 'cart_products';

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }


    // protected function show_query()
    // {
    //     DB::enableQueryLog();

    //     $this->belongsTo(Product::class, 'product_id');

    //     $query = DB::getQueryLog();

    //     dd($query);
    // }
}
