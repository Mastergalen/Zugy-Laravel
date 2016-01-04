@section('title', 'Sign up')

@extends('layouts.default')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="page-header">
            <h1>{!! trans('auth.register.title') !!}</h1>
        </div>
        <div class="login">
            <p>{!! trans('auth.register.social-tip') !!}</p>
            @include('includes._login-social')
        </div>
        <hr>
        <div class="panel panel-default">
            <div class="panel-heading">{!! trans('auth.register.title') !!}</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ action('Auth\AuthController@postRegister') }}">
                    {!! csrf_field() !!}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">{!! trans('checkout.address.form.name') !!}</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}">

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">{!! trans('auth.form.email.label') !!}</label>

                        <div class="col-md-6">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">{!! trans('auth.form.password.label') !!}</label>

                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">{!! trans('auth.form.confirm-password.label') !!}</label>

                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password_confirmation">

                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>s
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <p class="help-text">
                                {!! trans('checkout.review.accept', [
                                    'siteName' => config('site.name'),
                                    'privacyPolicyUrl' => localize_url('routes.privacy-policy'),
                                    'termsAndConditionsUrl' => localize_url('routes.terms-and-conditions'),
                                ]) !!}
                            </p>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-user"></i> {!! trans('auth.register.button') !!}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection