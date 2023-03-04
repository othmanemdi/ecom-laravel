<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartProductsResource;
use App\Models\Cart;
use App\Models\CartProducts;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CartProductsController extends Controller
{
    public function CreateCart()
    {
        return Cart::firstOrCreate(
            ['user_id' => auth()->id()]
        );
    }

    protected function addToCart(Request $request)
    {
        $cart = $this->CreateCart();

        $validatedData = $request->validate([
            'product_id' => ['required']
        ]);

        CartProducts::updateOrCreate(
            [
                'cart_id' => $cart->id,
                'product_id' => (int)$request->product_id,
            ],
            [
                'quantity' => DB::raw('quantity+1'),
            ]
        );
        return response()->json($validatedData, Response::HTTP_CREATED);
    }

    public function cartList()
    {
        $cart = $this->CreateCart();

        return CartProductsResource::collection(CartProducts::with('product')->where('cart_id', $cart->id)->get());
    }


    protected function incrementCart(Request $request)
    {
        $cart = $this->CreateCart();

        $validatedData = $request->validate([
            'product_id' => ['required']
        ]);

        CartProducts::updateOrCreate(
            [
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
            ],
            [
                'quantity' => DB::raw('quantity+1'),
            ]
        );

        return response()->json($validatedData, Response::HTTP_CREATED);
    }

    protected function decrementCart(Request $request)
    {
        $cart = $this->CreateCart();

        $validatedData = $request->validate([
            'product_id' => ['required'],
        ]);

        $quantity = CartProducts::select('quantity')->where('cart_id', $cart->id)->where('product_id', $request->product_id)->first()->quantity;
        // return $quantity;

        if ($quantity > 1) {
            CartProducts::updateOrCreate(
                [
                    'cart_id' => $cart->id,
                    'product_id' => $request->product_id,
                ],
                [
                    'quantity' => DB::raw('quantity-1'),
                ]
            );
            return response()->json($validatedData, Response::HTTP_CREATED);
        }

        return response()->json("Quantité invalide", Response::HTTP_ACCEPTED);
    }

    protected function removeFromCart(Request $request)
    {
        $cart = $this->CreateCart();

        $validatedData = $request->validate([
            'product_id' => ['required'],
        ]);

        $item = CartProducts::select('id')->where('cart_id', $cart->id)->where('product_id', $request->product_id)->firstOrFail();

        if ($item) {
            $item->delete();
            return response()->json($validatedData, Response::HTTP_ACCEPTED);
        }

        return response()->json("Produit introuvable", Response::HTTP_ACCEPTED);
    }

    public function getTotal()
    {
        $cart = $this->CreateCart();

        $total = DB::table('cart_products')
            ->select(DB::raw('sum((products.price * cart_products.quantity) /100) as total'))
            ->where('cart_products.cart_id', '=', $cart->id)
            ->leftJoin('products', 'cart_products.product_id', '=', 'products.id')
            ->first()->total;

        return number_format($total, 2, ',', ' ');
    }
}
