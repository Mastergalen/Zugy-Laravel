@section('title', 'Order placed!')
@extends('pages.checkout.partials.template')

@section('css')
    @parent


@endsection

@section('content')
    <div class="page-header">
        <h1>Order placed <i class="fa fa-smiley"></i></h1>
    </div>
    @include('pages.checkout.partials.age-warning')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <p>Your order has been placed. We will notify via email you when your order is out for delivery.</p>

    <p>You can expect to your receive in under 1 hour.</p>

    <hr>

    @include('includes.order-template')

@endsection

@section('scripts')
@endsection