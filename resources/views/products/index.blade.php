@extends('layouts.app')
@section('title', 'Products in the store')
@section('content')

  <!-- Bootstrap template -->
  <div class="container">
    <div class="page-header">
      <h1>Products list</h1>
    </div>
    @if (count($products) > 0)
    <div class="row">
      @foreach ($products as $product)
      <div class="col-sm-6 products-cell">
        <div class="panel panel-primary">
          <div class="panel-heading">
              <div class="col-sm-9 title"><a href="{{action('ProductsController@index', ['id' => $product->id])}}">{{ $product->title }}</a></div>
              @if ($product->discount > 0)
                  <div class="col-sm-3 price discounted-price text-right">${{ round($product->price - $product->price * $product->discount / 100, 2) }}</div>
              @else
                <div class="col-sm-3 price text-right">${{ $product->price }}</div>
              @endif
          </div>
          <div class="panel-body">
              @if (count($product->images) > 0 )
                  <a href="{{action('ProductsController@index', ['id' => $product->id])}}"><img src="{{ $product->images[0]->path }}" class="img-responsive" alt="{{ $product->title }}" /></a>
              @else
                  <img src="https://placehold.it/540x300?text=IMAGE" class="img-responsive" alt="Image is not available">
              @endif
          </div>
          <div class="panel-footer">{{ substr($product->description, 0, 150) }}</div>
        </div>
      </div>
      @endforeach
    </div>
    @else
    <div class="row">
        <div class="panel panel-danger">
            <div class="panel-body">There are no products available in the store</div>
        </div>
    </div>
    @endif
  </div>

@endsection
