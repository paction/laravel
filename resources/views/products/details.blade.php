@extends('layouts.app')
@section('title', $product->title)
@section('content')

    <div class="container product-details">
        <div class="page-header">
            <h1>{{ $product->title }}</h1>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <article>
                    <h3>Product Description</h3>
                    {{ $product->description }}
                </article>
                <article>
                    <h3>Available sizes</h3>

                @if (count($options['sizes']) > 0 )
                    <select id="size">
                    @foreach ($options['sizes'] as $size)
                        <option value="{{ $size }}">{{ $size }}</option>
                    @endforeach
                    </select>
                @else
                    <p class="bg-warning">No sizes available</p>
                @endif
                </article>
                <article>
                    <h3>Available colors</h3>

                @if (count($options['colors']) > 0 )
                    <select id="color">
                    @foreach ($options['colors'] as $color)
                        <option value="{{ $color }}">{{ $color }}</option>
                    @endforeach
                    </select>
                @else
                    <p class="bg-warning">No colors available</p>
                @endif
                </article>
                <div class="row">
                    <div class="panel-body text-left">
                        <p class="price">
                        @if ($product->discount > 0)
                            <span class="discounted-price">
                                ${{ round($product->price - $product->price * $product->discount / 100, 2) }}
                                <sup>price reduced!</sup>
                            </span>
                        @else
                            ${{ $product->price }}
                        @endif
                        </p>
                        <p>
                            <a href="#" class="btn btn-primary add-to-cart" data-title="{{ $product->title }}"
                               data-id="{{ $product->id }}" role="button">Add to cart</a>
                            <input type="number" value="1" id="quantity" /> items
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <h3>Product Images</h3>
                @if (count($product->images) > 0 )
                @foreach ($product->images as $image)
                    <div class="col-sm-6">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <img src="{{ $image->path }}" class="img-responsive" alt="{{ $product->title }}, image {{ $image->order }}" />
                            </div>
                        </div>
                    </div>
                @endforeach
                @else
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <img src="https://placehold.it/540x300?text=IMAGE" class="img-responsive" alt="Image is not available">
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @if ($product->bundle)
        <div class="row bundle">
            <div class="panel-body text-left">
                <h3>Buy these products to get a bundle discount!</h3>
                <p>
                    The price for the bundle is: <strong class="bg-warning">${{ $bundlePrice }}</strong> instead of ${{ $regularPrice }}
                </p>

                @foreach ($bundle as $bundleProduct)
                    <div class="col-sm-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a href="{{action('ProductsController@index', ['id' => $bundleProduct->id])}}" target="_blank">{{ $bundleProduct->title }}</a>
                                @if ($bundleProduct->discount > 0)
                                    <span class="discounted-price">
                                        ${{ round($bundleProduct->price - $bundleProduct->price * $bundleProduct->discount / 100, 2) }}
                                    </span>
                                @else
                                    ${{ $bundleProduct->price }}
                                @endif
                            </div>
                            <div class="panel-body">
                                @if (count($bundleProduct->images) > 0 )
                                    <a href="{{action('ProductsController@index', ['id' => $bundleProduct->id])}}">
                                        <img src="{{ $bundleProduct->images[0]->path }}" class="img-responsive" alt="{{ $bundleProduct->title }}" />
                                    </a>
                                @else
                                    <img src="https://placehold.it/540x300?text=IMAGE" class="img-responsive" alt="Image is not available">
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

@endsection
