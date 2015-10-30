@section('title', 'Zugy - Alcohol Delivery on-demand for Milan')

@extends('layouts.master')

@section('content')
    <div class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="/img/carousel/alcohol-drinks.jpg" style="margin:auto;">
                <div class="carousel-caption">
                    <div>
                        @include('includes.notifications')
                        <img src="/img/zugy-logo-dark.png" alt="Zugy Dark Logo"/>
                        <h4>Your favorite beer, wine, spirits delivered to your doorstep</h4>

                        <form action="/en/shop/category/alcohol" method="GET">
                            {!! Form::token() !!}
                            <div class="input-group">
                                <input class="form-control" type="text" name="postcode" placeholder="Enter your postcode" autocomplete="off"/>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit">Shop now</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row marketing">
            <div class="col-md-4">
                <i class="fa fa-map-marker"></i>
                <h4>Set your address</h4>
                <p>Select from a wide range of alcholic drinks to be delivered to your door step.</p>
            </div>
            <div class="col-md-4">
                <i class="fa fa-clock-o"></i>
                <h4>Order in minutes</h4>
                <p>Add what you want to your basket, pay at the checkout and you're done.</p>
            </div>
            <div class="col-md-4">
                <i class="fa fa-truck"></i>
                <h4>Delivery to your door</h4>
                <p>We'll start preparing your order right away, and deliver it to your doorstep. Simply present your photo ID to our friendly drivers and enjoy!</p>
            </div>
        </div>
    </div>

    <hr/>

    <div class="locations">
        <h4>Currently Serving Milan Exclusively</h4>

        <p>With many plans to expand</p>

        <div class="parallax">
            <span>MILAN</span>
        </div>
    </div>
@endsection