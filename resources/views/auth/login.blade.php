@section('title', 'Log in to Zugy')

@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="login">
                <h3>Login or <a href="{!! action('Auth\AuthController@getRegister') !!}">Sign up</a></h3>

                @include('includes._login-social')

                <div class="login-or">
                        <hr/>
                        <span>or</span>
                </div>
                <form action="{!! action('Auth\AuthController@postLogin') !!}" method="POST">
                    {!! Form::token() !!}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    {!! Form::text('email', Input::old('email'), ['class' => 'form-control', 'placeholder' => 'E-Mail']) !!}
                                </div>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                </div>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="pull-left">
                                <div class="checkbox">
                                    <label>
                                        {!! Form::checkbox('remember', 'true', Input::old('remember', true)) !!}Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pull-right">
                                <p><a href="{!! action('Auth\PasswordController@getEmail') !!}">Forgot password?</a></p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop