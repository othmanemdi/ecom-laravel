<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderProductsResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProducts;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderProdiuctsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function orderList()
    {
        return OrderProductsResource::collection(OrderProducts::with('product')->get());
    }

    public function createOrder()
    {
        $order = Order::create(['user_id' => auth()->id()]);

        foreach (Cart::content() as $item) {
            OrderProducts::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
            ]);

            // $product = Product::find($item->product_id);
            // $product->update(['quantity' => $product->quantity - $item->quantity]);
        }

        Cart::clear();

        return response()->json("Bien ajouter", Response::HTTP_CREATED);
    }
}
