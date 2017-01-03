<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Products;

class APagesTest extends TestCase
{
    public function testWelcomePage()
    {
        $this->visit('/')
             ->see('Laravel');
    }

    public function testProductsPage()
    {
        $this->visit('/')
            ->click('Products List')
            ->seePageIs('/products');
    }

    public function testCartPage()
    {
        $this->visit('/')
            ->click('Cart')
            ->seePageIs('/cart');

        $this->visit('/cart')
            ->click('Products list')
            ->seePageIs('/products');
    }

    public function testProductPage()
    {
        $product = Products::orderBy('id', 'desc')->first();
        
        $this->visitRoute('products', ['id' => $product->id])
            ->see('Product Description');
    }
}
