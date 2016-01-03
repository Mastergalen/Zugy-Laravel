@extends('admin.layouts.default')

@section('title', $customer->name . ' - Customer')

@section('header')
    <h1><i class="fa fa-user"></i> Customer</h1>
@endsection

@section('breadcrumb')
    <li>
        <a href="{!! action('Admin\CustomerController@index') !!}">Customers</a>
    </li>
    <li class="active">
        <strong>{{ $customer->name }}</strong>
    </li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-body">
                    <div class="media">
                        <div class="media-left">
                            <img src="http://www.gravatar.com/avatar/{!! md5( strtolower( trim( $customer->email ) ) )  !!}" style="border-radius: 50%;"/>
                        </div>
                        <div class="media-body">
                            <h1>{{$customer->name}}</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Contact</h3>
                            <dl>
                                <dt>E-Mail</dt>
                                <dd>{{ $customer->email }}</dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <h3>Default address</h3>
                            @include('includes._address', ['address' => Checkout::getShippingAddress($customer)])
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-dollar"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Lifetime Revenue</span>
                    <span class="info-box-number">{{ money_format("%i", $customer->orders()->get()->sum('grand_total')) }}&euro;</span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-shopping-cart"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Ordres</span>
                    <span class="info-box-number">{{ $customer->orders()->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Orders</h3>
        </div>
        <div class="box-body no-padding">

            @include('admin.partials._order-list', ['orders' => $customer->orders()->paginate(30)])

        </div>
    </div>

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">
                Miscellaneous
            </h3>
        </div>
        <div class="box-body">
            <dl>
                <dt>Account created</dt>
                <dd>{{ $customer->created_at }}</dd>
                <dt>Last login</dt>
                <dd>{{ $customer->last_login }}</dd>
                <dt>Current items in cart</dt>
                <dd>{{ $customer->basket()->count() }}</dd>
            </dl>
        </div>
    </div>
@endsection