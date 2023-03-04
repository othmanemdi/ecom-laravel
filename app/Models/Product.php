<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'products';

    protected $fillable = ['reference', 'image', 'name', 'description', 'category_id', 'price', 'old_price'];


    protected function Reference(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucwords($value),
            set: fn ($value) => strtolower($value),
        );
    }

    protected function Name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucwords($value),
            set: fn ($value) => strtolower($value),
        );
    }

    protected function Price(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value / 100, 2, ',', ' ') . ' DH',
            set: fn ($value) => $value * 100,
        );
    }

    protected function OldPrice(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value / 100, 2, ',', ' ') . ' DH',
            set: fn ($value) => $value * 100,
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function carts(): BelongsToMany
    {
        return $this->belongsToMany(Cart::class, 'cart_products', 'cart_id', 'product_id');
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_products', 'order_id', 'product_id');
    }
}
