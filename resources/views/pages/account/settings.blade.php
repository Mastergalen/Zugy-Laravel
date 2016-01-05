@section('title',  trans('menu.account-settings'))

@extends('layouts.default')

@section('content')
    <div class="page-header">
        <h1>{!! trans('menu.account-settings') !!}</h1>
    </div>

    <form action="{!! action('Auth\PasswordController@postPasswordChange') !!}" method="POST" class="form-horizontal">
        <legend>{!! trans('auth.form.password.change') !!}</legend>
        {!! csrf_field() !!}

        @if(auth()->user()->password !== null)
            <div class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
                <label class="col-md-4 control-label">{!! trans('auth.form.password_current.label') !!}</label>

                <div class="col-md-6">
                    <input type="password" class="form-control" name="current_password">

                    @if ($errors->has('current_password'))
                        <span class="help-block">
                    <strong>{{ $errors->first('current_password') }}</strong>
                </span>
                    @endif
                </div>
            </div>
        @endif

        @include('auth.passwords.partials._password-input')

        <div class="form-group">
            <div class="col-md-offset-4 col-md-6">
                <button class="btn btn-primary" type="submit">{!! trans('buttons.change') !!}</button>
            </div>
        </div>
    </form>
@endsection


