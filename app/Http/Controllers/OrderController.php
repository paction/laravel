<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\OrderCreated;
use App\Orders;
use App\OrderItems;

class OrderController extends Controller
{
    /**
     * Place order.
     *
     * @param  Request  $request
     * @return Response
     */
    public function place(Request $request) {

        $this->validate($request, [
            'email' => 'required|email|max:255'
        ]);

        $errors = [];
        $orderId = null;

        $cart = $request->session()->get('cart');
        $cartOptions = $request->session()->get('cartOptions');

        if(!empty($cart) && !empty($cartOptions)) {
            $cart = (array)json_decode($cart);
            $cartOptions = json_decode($cartOptions, true);

            $order = new Orders;
            $order->email = $request->email;
            $order->amount = (double)$cartOptions['total'];
            $order->status = 'NEW';
            if($order->save()) {
                foreach($cart as $item) {
                    $orderItem = new OrderItems;
                    $orderItem->orders_id = $orderId = $order->id;
                    $orderItem->products_id = $item->products_id;
                    $orderItem->quantity = $item->quantity;
                    // This part can be redone to pull price from the database instead of session
                    $orderItem->amount = ($item->bundlePrice ? $item->bundlePrice : $item->price) * $item->quantity;
                    $orderItem->options = json_encode((object)['size' => $item->size, 'color' => $item->color]);
                    if(!$orderItem->save()) {
                        $errors[] = 'Order item ' . $item->products_id . ' is not created';
                    }
                }

                $request->session()->put('cart', json_encode([]));
                $request->session()->put('cartOptions', json_encode([]));
                $request->session()->put('cartProductIndex', json_encode([]));

                event(new OrderCreated($order));
            } else {
                $errors[] = 'Order is not created';
            }
        } else {
            $errors[] = 'Cart is empty';
        }

        return view('order.place', [
            'otherErrors' => $errors,
            'orderId' => $orderId
        ]);
    }
}
