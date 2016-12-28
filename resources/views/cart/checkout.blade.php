@extends('layouts.app')
@section('title', 'Your Cart')
@section('content')

    <div class="container cart">
        <div class="page-header">
            <h1>Checkout</h1>
        </div>
        <div class="row">
            @if(!empty($cart))
                {!! Form::open(['action' => ['OrderController@place']]) !!}
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Fill the form below
                    </div>
                    <div class="panel-body">
                        {{ Form::token() }}

                        @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-lg-2 col-md-3 col-sm-4">
                                {{ Form::label('email', 'Your E-Mail Address') }}:
                            </div>
                            <div class="col-lg-10 col-md-9 col-sm-8">
                                {{ Form::text('email', null, ['placeholder' => 'Your email']) }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                Total: ${{ $total }}
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                {{ Form::submit('Place Order', ['class' => 'btn btn-primary']) }}
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 text-right">
                                {{ Form::reset('Reset', ['class' => 'btn btn-default']) }}
                                <a class="btn btn-warning" href="{{ action('CartController@index') }}">Return to cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
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
