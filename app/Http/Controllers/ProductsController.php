<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Products;

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
            $products = Products::all();
            
            return view('products.index', [
                'products' => $products,
            ]);
        } else {
            $product = Products::find($id);
            
            if($product) {

                // Pull Options
                $productOptions = $product->options;
                $options = ['sizes' => [], 'colors' => []];
                foreach ($productOptions as $option) {
                    $option->option == 'size' ? $options['sizes'][] = $option->value : $options['colors'][] = $option->value;
                }

                // Just to avoid duplicates from seeders
                $options['sizes'] = array_unique($options['sizes']);
                $options['colors'] = array_unique($options['colors']);

                // Pull Bundle
                $bundle = [];
                if($product->bundle > 0) {
                    $bundle = Products::where([['bundle', '=', $product->bundle], ['id', '<>', $product->id]] )->get();
                    if(count($bundle)) {
                        $regularPrice = $product->discount > 0 ? $product->price - $product->price * $product->discount / 100 : $product->price;
                        foreach ($bundle as $bundleProduct) {
                            $regularPrice += $bundleProduct->discount > 0 ? $bundleProduct->price - $bundleProduct->price * $bundleProduct->discount / 100 : $bundleProduct->price;
                        }
                        // Reducing by 10%
                        $bundlePrice = round(($regularPrice - $regularPrice * 0.1), 2);
                    }
                }

                return view('products.details', [
                    'product' => $product,
                    'options' => $options,
                    'bundle' => $bundle,
                    'bundlePrice' => isset($bundlePrice) ? $bundlePrice : 0,
                    'regularPrice' => isset($regularPrice) ? $regularPrice : 0
                ]);
            } else {
                //error
            }
        }
    }
}
