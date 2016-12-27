<?php

namespace App\Http\Controllers;

use App\Products;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private $bundles = [];
    private $cart;
    private $cartProductIndex = [];
    private $cartOptions = [];

    /**
     * Shows the cart.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request) {
        $this->cart = $request->session()->get('cart');
        $this->cartProductIndex = $request->session()->get('cartProductIndex');
        $this->cartOptions = $request->session()->get('cartOptions');
        $this->_decodeCart();

        return view('cart.index', [
            'cart' => $this->cart ? $this->cart : [],
            'total' => $this->cartOptions['total'],
            'bundles' => $this->cartOptions['bundles']
        ]);
    }

    /**
     * Adds a product into the cart.
     *
     * @param  Request  $request
     * @return Response (json)
     */
    public function add(Request $request) {
        if (!$request->isMethod('post')){
            return \Response::json(['response' => 'Should be post']);
        }

        $data = $request->all();

        $this->_pullCartFromSession($request);

        $sameProductExists = false;
        $this->_decodeCart();
        if($this->cart) {
            if(isset($this->cartProductIndex[$data['products_id']])) {
                foreach ($this->cartProductIndex[$data['products_id']] as $index => $indexItem) {
                    // Search for the same options
                    if($indexItem == $data['size'] . $data['color']) {
                        // Add quantity
                        $this->cart[$index]->quantity += (int)$data['quantity'];
                        $this->cartOptions['cartCounter'] += $data['quantity'];
                        $sameProductExists = true;
                        break;
                    }
                }
            }
        }

        if(!$sameProductExists) {
            $this->_addProductToCart($data);
        }

        $this->_putCartToSession($request);

        $response = [
            'status' => 'success',
            'msg' => 'Added successfully.',
            'counter' => $this->cartOptions['cartCounter']
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

        $this->_pullCartFromSession($request);
        $this->_decodeCart();

        if($this->cart && isset($data['k'])) {

            $this->cartOptions['cartCounter'] -= $this->cart[$data['k']]->quantity;

            if(count($this->cartProductIndex[$this->cart[$data['k']]->products_id]) == 1) {
                unset($this->cartProductIndex[$this->cart[$data['k']]->products_id]);
            }

            unset($this->cart[$data['k']]);

            $this->_putCartToSession($request);

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

    /**
     * Checkout.
     *
     * @param  Request  $request
     * @return Response
     */
    public function checkout(Request $request) {
        $this->cart = $request->session()->get('cart');
        $this->cartOptions = $request->session()->get('cartOptions');
        $this->_decodeCart();

        return view('cart.checkout', [
            'cart' => $this->cart ? $this->cart : [],
            'total' => $this->cartOptions['total']
        ]);
    }

    /*
     * Removes incomplete bundles
     */
    private function _processBundles()
    {
        if($this->cart) {
            foreach ($this->cartProductIndex as $k => $item) {
                $product = Products::find($k);
                if ($product) {
                    if ($product->bundle) {
                        $this->bundles[$product->bundle][] = $k;
                    }
                } else {
                    //Error
                }
            }

            if (!empty($this->bundles)) {
                $this->cartOptions['bundles'] = false;
                foreach ($this->bundles as $k => $bundle) {
                    if (count($bundle) != Products::where('bundle', $k)->count()) {
                        foreach ($bundle as $productInBundle) {
                            foreach ($this->cartProductIndex[$productInBundle] as $index => $value) {
                                $this->cart[$index]->bundlePrice = 0;
                            }
                        }
                        unset($this->bundles[$k]);
                    } else {
                        foreach ($bundle as $productInBundle) {
                            foreach ($this->cartProductIndex[$productInBundle] as $index => $value) {
                                $this->cart[$index]->bundlePrice =
                                    round($this->cart[$index]->price * (1 - \Config::get('custom.bundles.discount')), 2);
                            }
                        }
                        $this->cartOptions['bundles'] = true;
                    }
                }
            }
        }
    }

    private function _generateRandomIndex()
    {
        return md5(time() + rand(1, 1000));
    }

    private function _decodeCart()
    {
        if(!empty($this->cart)) {
            $this->cart = (array)json_decode($this->cart);
        }
        if(!empty($this->cartProductIndex)) {
            $this->cartProductIndex = json_decode($this->cartProductIndex, true);
        }
        if(!empty($this->cartOptions)) {
            $this->cartOptions = json_decode($this->cartOptions, true);
        }
        if(!isset($this->cartOptions['total'])) {
            $this->cartOptions['total'] = 0;
        }
        if(!isset($this->cartOptions['cartCounter'])) {
            $this->cartOptions['cartCounter'] = 0;
        }
        if(!isset($this->cartOptions['bundles'])) {
            $this->cartOptions['bundles'] = false;
        }
    }

    /*
     * Calculates total amount.
     *
     * @return double $total
     */
    private function _calcTotal()
    {
        $total = 0;
        foreach ($this->cart as $item) {
            $total += ($item->bundlePrice ? ($item->bundlePrice * $item->quantity) : ($item->price * $item->quantity));
        }
        return $total;
    }

    private function _pullCartFromSession($request)
    {
        $this->cartOptions = $request->session()->pull('cartOptions');
        $this->cart = $request->session()->pull('cart');
        $this->cartProductIndex = $request->session()->pull('cartProductIndex');
    }

    private function _putCartToSession($request)
    {
        $this->_processBundles();
        $this->cartOptions['total'] =  $this->_calcTotal();
        $this->cartOptions['total'] =  $this->_calcTotal();
        $request->session()->put('cart', json_encode($this->cart));
        $request->session()->put('cartProductIndex', json_encode($this->cartProductIndex));
        $request->session()->put('cartOptions', json_encode($this->cartOptions));
    }

    private function _addProductToCart($data)
    {
        $product = Products::find((int)$data['products_id']);
        $index = $this->_generateRandomIndex();
        $this->cart[$index] = (object) [
            'products_id' => (int)$data['products_id'],
            'quantity' => (int)$data['quantity'],
            'title' => $data['title'],
            'size' => $data['size'],
            'color' => $data['color'],
            'price' => $product->getPrice(),
            'bundlePrice' => 0
        ];

        // Add product into Product index
        $this->cartProductIndex[(int)$data['products_id']][$index] = $data['size'] . $data['color'];

        if(!isset($this->cartOptions['cartCounter'])) {
            $this->cartOptions['cartCounter'] = 0;
        }
        $this->cartOptions['cartCounter'] += $data['quantity'];
    }
}
