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
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($cart as $k => $item)
                <tr>
                    <td>{{ $k + 1 }}</td>
                    <td>
                        <p><a href="/products/?id={{ $item->products_id }}">
                            {{ isset($item->title) ? $item->title : $item->products_id }}
                        </a></p>
                        <p class="small">
                            Selection: {{ $item->size }} {{ $item->color }}
                        </p>
                    </td>
                    <td>{{ $item->quantity }}</td>
                    <td><a href="#" class="remove-from-cart" data-k="{{ $k }}">Remove</a></td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">
                        Total:
                    </td>
                </tr>
            </tfoot>
        </table>
        <p>Go to the <a href="/products">Products list</a> and add some more</p>
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
