<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
    * Shows the list of products.
    *
    * @param  Request  $request
    * @return Response
    */
    public function index(Request $request)
    {
        $id = (int)$request->input('id');
        if(!$id) {
            $products = App\Products::all();
            
            return view('products.index', [
                'products' => $products,
            ]);
        } else {
            $product = App\Products::find($id);
            
            if($product) {
                return view('products.details', [
                    'product' => $product,
                ]);
            } else {
                //error
            }
        }
    }
}
