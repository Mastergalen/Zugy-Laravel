@section('title', 'Checkout')

@extends('layouts.default')

@section('css')
    <style>
        .login .social-buttons a {
            color: white;
            opacity: 0.9;
        }

        .login .social-buttons a:hover {
            color: white;
            opacity:1;
        }

        .login .social-buttons .btn-facebook {background: #3b5998;}
        .login .social-buttons .btn-twitter {background: #00aced;}
        .login .social-buttons .btn-google {background: #4285f4;;}

        .login .login-or {
            position: relative;
            font-size: 1.5em;
            color: #aaa;
            margin-top: 1em;
            margin-bottom: 1em;
            padding-top: 0.5em;
            padding-bottom: 0.5em;
        }
        .login .login-or hr {
            background-color: #cdcdcd;
            height: 1px;
            margin-top: 0px !important;
            margin-bottom: 0px !important;
        }
        .login .login-or span {
            display: block;
            position: absolute;
            left: 50%;
            top: -0.6em;
            margin-left: -1.5em;
            background-color: white;
            width: 3em;
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="login">
                <h3>Login or <a href="#">Sign up</a></h3>

                <div class="row social-buttons">
                    <div class="col-xs-6">
                        <a href="/auth/login/facebook" class="btn btn-lg btn-block btn-facebook">
                            <i class="fa fa-facebook"></i>
                            <span class="hidden-xs">Facebook</span>
                        </a>
                    </div>
                    <div class="col-xs-6">
                        <a href="/auth/login/google" class="btn btn-lg btn-block btn-google">
                            <i class="fa fa-google"></i>
                            <span class="hidden-xs">Google</span>
                        </a>
                    </div>
                </div>

                <div class="login-or">
                    <hr/>
                    <span>or</span>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <form action="" autocomplete="off" method="POST">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" name="username" placeholder="email address">
                                </div>
                                <span class="help-block"></span>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                </div>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="pull-left">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="remember">Remember Me
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            <p><a href="#">Forgot password?</a></p>
                        </div>
                    </div>
                </div>

                <h3>Checkout as guest</h3>
                <p>Don't have an account and you don't want to register? Checkout as a guest instead!</p>
                <a href="{!! localize_url('routes.checkout.landing') !!}?guestCheckout" class="btn btn-primary">Checkout as guest</a>
            </div>
        </div>
    </div>
@stop