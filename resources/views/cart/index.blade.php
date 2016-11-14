@extends('layouts.app')
@section('title', 'Your Cart')
@section('content')

<div class="container product-details">
  <div class="page-header">
    <h1>Your Cart</h1>
  </div>
  <div class="row">
    @if(!empty($cart))
        <table class="table table-hover">
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
            @foreach($cart as $k => $item)
            <tr>
                <td>{{ $k }}</td>
                <td>
                    <a href="/products/?id={{ $item->products_id }}">
                        {{ isset($item->title) ? $item->title : $item->products_id }}
                    </a>
                    {{ $item->size }} {{ $item->color }}
                </td>
                <td>{{ $item->quantity }}</td>
                <td>Remove</td>
            </tr>
            @endforeach
        </table>
    @else
    <div class="panel panel-danger">
        <div class="panel-body">
          <p>Your cart is empty</p>
          <p>Go to the <a href="/products">Products list</a> and add something into the cart</p>
        </div>
    </div>
    @endif
  </div>
</div>
@endsection
