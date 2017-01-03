<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Products;
use App\Orders;

class BCartTest extends TestCase
{
    public function testPlaceToCart()
    {
        $product = Products::orderBy('id', 'desc')->first();

        $this->visitRoute('products', ['id' => $product->id]);

        $randomQuantity = rand(99, 120);

        // Options index init
        $optionsIndex = ['size', 'color'];
        $numberOfCartOptions = count($optionsIndex);
        foreach ($optionsIndex as $item) {
            $optionData[$item] = '';
        }

        $placedOptions = 0;

        foreach ($product->options as $productOptionKey => $option) {
            if(empty($optionData[$productOptionKey])) {
                $optionData[$productOptionKey] = $option;
                $placedOptions++;
            }

            if($numberOfCartOptions == $placedOptions) {
                break;
            }
        }

        $data = [
            'products_id'   => $product->id,
            'title'         => $product->title,
            'quantity'      => $randomQuantity,
        ];

        $data += $optionData;

        $this->json('POST', '/cart', $data)
            ->seeJson([
                'counter' => $randomQuantity,
            ]);

        $this->seeInSession('cart');
        return Session::all();
    }

    public function testRemoveFromCartEmptyParams()
    {
        $this->json('DELETE', '/cart', [])
            ->seeJson([
                'msg' => 'Empty item index.',
            ]);
    }

    /**
     * @depends testPlaceToCart
     */
    public function testRemoveFromCart($session)
    {
        Session::put($session);
        $cart = json_decode(Session::get('cart'));
        reset($cart);
        $first_key = key($cart);
        $this->json('DELETE', '/cart', ['k' => $first_key])
            ->seeJson([
                'status' => 'success',
            ]);
    }

    /**
     * @depends testRemoveFromCart
     */
    public function testRemoveFromEmptyCart()
    {
        $this->json('DELETE', '/cart', ['k' => 'some_key'])
            ->seeJson([
                'msg' => 'Your cart is already empty.',
            ]);
    }

    /**
     * @depends testPlaceToCart
     */
    public function testOrder($session)
    {
        Session::put($session);

        $this->assertArrayHasKey('cartOptions', $session);

        $amount = json_decode($session['cartOptions']);
        $amount = $amount->total;

        $this->visit('/cart')
            ->click('Checkout')
            ->type('someemail@gmail.com', 'email')
            ->press('Place Order')
            ->see('is placed.');
        $html = $this->response->getContent();

        preg_match("'<span id=\"orderId\">(.*?)</span>'si", $html, $orderId);

        if($orderId && isset($orderId[1])) {
            $orderId = $orderId[1];
        }

        $this->assertJsonStringEqualsJsonString('[]', Session::get('cart'));

        return ['amount' => $amount, 'orderId' => $orderId];
    }

    /**
     * @depends testOrder
     */
    public function testOrderMade($data)
    {
        $order = Orders::where('id', (int)$data['orderId'])->first();
        $this->assertNotEmpty($order);
        $this->assertEquals($data['amount'], $order->amount);

        Orders::where('id', $data['orderId'])->delete();
    }
}
