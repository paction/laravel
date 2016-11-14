<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Shows the cart.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request) {
        $cart = $request->session()->get('cart');

        return view('cart.index', [
            'cart' => $cart ? json_decode($cart) : [],
        ]);
    }

    /**
     * Adds product into the cart.
     *
     * @param  Request  $request
     * @return Response (json)
     */
    public function add(Request $request) {
        if (!$request->isMethod('post')){
            return \Response::json(['response' => 'Should be post']);
        }

        $data = $request->all();

        $cart = $request->session()->pull('cart');

        $productExists = false;

        $counter = 0;

        if($cart) {
            $cart = json_decode($cart);

            // Check for existing product - adding quantity
            foreach ($cart as $k => $product) {
                if($product->products_id == $data['products_id']
                    && $product->size == $data['size']
                    && $product->color == $data['color']
                ) {
                    $cart[$k]->quantity += $data['quantity'];
                    $productExists = true;
                }

                $counter += $cart[$k]->quantity;
            }
        }

        if(!$productExists) {
            $cart[] = [
                'products_id' => $data['products_id'],
                'quantity' => $data['quantity'],
                'title' => $data['title'],
                'size' => $data['size'],
                'color' => $data['color']
            ];
            $counter += $data['quantity'];
        }

        $request->session()->put('cart', json_encode($cart));

        $response = [
            'status' => 'success',
            'msg' => 'Added successfully.',
            'counter' => $counter
        ];

        return \Response::json($response);
    }
}
