<?php

namespace App\Http\Controllers;

use App\Products;
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

        $bundles = [];

        foreach ($cart as $item) {
            $product = Products::find($item->products_id);
            if($product) {
                $price = ($product->discount > 0) ?
                    ($product->price - $product->price * $product->discount / 100) : $product->price;
                if($product->bundle && !isset($bundles[$product->bundle])) {
                    $bundles[$product->bundle][] = $item->products_id;
                }
            } else {
                //Error
            }
        }

        //$total += ;


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

    /**
     * Removes a cart item.
     *
     * @param  Request  $request
     * @return Response (json)
     */
    public function delete(Request $request)
    {
        if (!$request->isMethod('delete')) {
            return \Response::json(['response' => 'Should be delete']);
        }

        $data = $request->all();

        $cart = $request->session()->pull('cart');

        if($cart && isset($data['k'])) {
            $cart = json_decode($cart);

            unset($cart[(int)$data['k']]);

            $cart = array_values($cart);

            $request->session()->put('cart', json_encode($cart));

            $response = [
                'status' => 'success',
                'msg' => 'Removed successfully.'
            ];
        } elseif(!isset($data['k'])) {
            $response = [
                'status' => 'error',
                'msg' => 'Empty item index.'
            ];
        } else {
            $response = [
                'status' => 'error',
                'msg' => 'Your cart is already empty.'
            ];
        }

        return \Response::json($response);
    }
}
