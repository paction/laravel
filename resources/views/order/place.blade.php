@extends('layouts.app')
@section('title', 'Your Order')
@section('content')
    <div class="container">
        <div class="page-header">
            <h1>Your Order</h1>
        </div>
        @if (count($otherErrors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($otherErrors as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="alert alert-success">
                <strong>Success!</strong> Your order #<span id="orderId">{{ $orderId }}</span> is placed.
            </div>
        @endif
    </div>
@endsection
