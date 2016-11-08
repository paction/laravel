@extends('layouts.app')
@section('title', $product->title)
@section('content')

    <!-- Bootstrap template -->
    <div class="container product-details">
        <div class="page-header">
            <h1>{{ $product->title }}</h1>
        </div>
        <div class="row">
            <div class="container">
                <div class="panel-body text-left">
                    <span class="price">
                    @if ($product->discount > 0)
                        <span class="discounted-price">${{ round($product->price - $product->price * $product->discount / 100, 2) }} <sup>price reduced!</sup></span>
                    @else
                        ${{ $product->price }}
                    @endif
                    </span>
                    <a href="#" class="btn btn-primary buy-now" role="button">Buy now</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                {{ $product->description }}
            </div>
            <div class="col-sm-8">
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
        <div class="row">
            <div class="container">
                <div class="panel-body text-right">
                    <span class="price">
                    @if ($product->discount > 0)
                            <span class="discounted-price">${{ round($product->price - $product->price * $product->discount / 100, 2) }} <sup>price reduced!</sup></span>
                        @else
                            ${{ $product->price }}
                        @endif
                    </span>
                    <a href="#" class="btn btn-primary buy-now" role="button">Buy now</a>
                </div>
            </div>
        </div>
    </div>

@endsection
