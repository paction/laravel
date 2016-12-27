<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Place order.
     *
     * @param  Request  $request
     * @return Response
     */
    public function place(Request $request) {
        $this->cart = $request->session()->get('cart');
        $this->cartProductIndex = $request->session()->get('cartProductIndex');
        $this->cartOptions = $request->session()->get('cartOptions');
        $this->_decodeCart();

        return view('order.place', [
            'total' => $this->cartOptions['total'],
        ]);
    }
}
