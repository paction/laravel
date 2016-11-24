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

        if($cart) {
            $cart = json_decode($cart);
            foreach ($cart as $k=>$item) {
                $product = Products::find($item->products_id);
                if($product) {
                    if($product->bundle && !isset($bundles[$product->bundle])) {
                        $bundles[$product->bundle][$item->products_id]['price'] = $item->price;
                    }
                } else {
                    //Error
                }
            }
        }
        //$total += ;

var_dump($bundles);
        return view('cart.index', [
            'cart' => $cart ? $cart : []
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
                    $cart[$k]->quantity += (int)$data['quantity'];
                    $productExists = true;
                }

                $counter += $cart[$k]->quantity;
            }
        }

        if(!$productExists) {
            $product = Products::find($data['products_id']);
            $cart[] = [
                'products_id' => (int)$data['products_id'],
                'quantity' => (int)$data['quantity'],
                'title' => $data['title'],
                'size' => $data['size'],
                'color' => $data['color'],
                'price' => $product->getPrice()
            ];
            $counter += (int)$data['quantity'];
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
