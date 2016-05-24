@extends('admin.layouts.default')

@section('title', $customer->name . ' - ' . trans('admin.customers.singular'))

@section('header')
    <h1><i class="fa fa-user"></i> {!! trans('admin.customers.singular') !!}</h1>
@endsection

@section('breadcrumb')
    <li>
        <a href="{!! action('Admin\CustomerController@index') !!}">{!! trans('admin.customers.title') !!}</a>
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
                            <h3>{!! trans('pages.contact.title') !!}</h3>
                            <dl>
                                <dt>{!! trans('auth.form.email.label') !!}</dt>
                                <dd>{{ $customer->email }}</dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <h3>{!! trans('admin.customers.address.default') !!}</h3>
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
                    <span class="info-box-text">{!! trans('admin.customers.revenue.lifetime') !!}</span>
                    <span class="info-box-number">{{ money_format("%i", $customer->orders()->uncancelled()->get()->sum('grand_total')) }}&euro;</span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-shopping-cart"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">{!! trans('admin.customers.orders_total') !!}</span>
                    <span class="info-box-number">{{ $customer->orders()->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-list"></i> {!! trans('admin.orders.title') !!}</h3>
                </div>
                <div class="box-body no-padding">

                    @include('admin.partials._order-list', ['orders' => $customer->orders()->paginate(30)])

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-shopping-cart"></i> {!! trans('cart.shopping-cart') !!}</h3>
                </div>
                <div class="box-body">
                    @forelse($customer->basket()->with('product')->get() as $item)
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="cart-product-thumb">
                                            <a href="{!! $item->product->getUrl() !!}"><img
                                                        src="{!! $item->product->thumbnail_url !!}"
                                                        alt="{{ $item->product->title }}"></a>
                                        </div>
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="cart-description">
                                            <h4><a href="{!! $item->product->getUrl() !!}">{{ $item->product->title }}</a></h4>

                                            <div class="price">{{ money_format("%i", $item->price) }}&euro;</div>

                                            <p><b>{!! trans('product.quantity') !!}: </b>{!! $item->quantity !!}</p>
                                        </div>
                                    </div>
                                    <div class="col-xs-5">
                                        <dl>
                                            <dt>{!! trans('admin.created_at') !!}</dt>
                                            <dl>{!! $item->created_at !!}</dl>
                                        </dl>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info">{!! trans('cart.mini-cart-empty') !!}</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">
                {!! trans('admin.miscellaneous') !!}
            </h3>
        </div>
        <div class="box-body">
            <dl>
                <dt>{!! trans('admin.created_at') !!}</dt>
                <dd>{{ $customer->created_at }}</dd>
                <dt>{!! trans('admin.last_login') !!}</dt>
                <dd>{{ $customer->last_login }}</dd>
            </dl>
        </div>
    </div>

    @can('signInAsUser', $customer)
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Danger Zone
                </h3>
            </div>
            <div class="box-body">
                <form action="{!! action('Auth\AuthController@postAdminLogin') !!}" method="POST">
                    {!! Form::token() !!}
                    {!! Form::hidden('user_id', $customer->id) !!}
                    <button type="submit" class="btn btn-danger"><i class="fa fa-user"></i> Sign in as this user</button>
                </form>
            </div>
        </div>
    @endcan
@endsection