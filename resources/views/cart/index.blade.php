@extends('layouts.app')
@section('title', 'Your Cart')
@section('content')

<div class="container cart">
  <div class="page-header">
    <h1>Your Cart</h1>
  </div>
  <div class="row">
    @if(!empty($cart))
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Price</th>
                    @if(!empty($bundles))
                        <th>Bundle Price</th>
                    @endif
                    <th>Quantity</th>
                    <th>Cost</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($cart as $i => $item)
                <tr>
                    <td>{{ isset($k) ? ++$k  : $k = 1 }}</td>
                    <td>
                        <p><a href="{{action('ProductsController@index', ['id' => $item->products_id])}}">
                            {{ isset($item->title) ? $item->title : $item->products_id }}
                        </a></p>
                        <p class="small">
                            Selection: {{ $item->size }} {{ $item->color }}
                        </p>
                    </td>
                    <td>${{ $item->price }}</td>
                    @if(!empty($bundles))
                        <td>${{ $item->bundlePrice }}</td>
                    @endif
                    <td>{{ $item->quantity }}</td>
                    @if($item->bundlePrice > 0)
                        <td>{{ $item->quantity * $item->bundlePrice }}</td>
                    @else
                        <td>{{ $item->quantity * $item->price }}</td>
                    @endif
                    <td><a href="#" class="remove-from-cart" data-k="{{ $i }}">Remove</a></td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="{{ !empty($bundles) ? 5 : 4 }}">
                        Total: ${{ $total }}
                    </td>
                    <td colspan="2" class="text-right">
                        <a href="{{action('CartController@checkout')}}" class="btn btn-primary checkout" role="button">Checkout</a>
                    </td>
                </tr>
            </tfoot>
        </table>
        <p>Go to the <a href="{{action('ProductsController@index')}}">Products list</a> and add some more</p>
    @else
    <div class="panel panel-danger">
        <div class="panel-body">
          <p>Your cart is empty</p>
          <p>Go to the <a href="{{action('ProductsController@index')}}">Products list</a> and add something into the cart</p>
        </div>
    </div>
    @endif
  </div>
</div>
@endsection
