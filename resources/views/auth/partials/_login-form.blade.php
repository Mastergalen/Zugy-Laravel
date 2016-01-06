<div class="login">
    <h3>{!! trans('auth.login.title', ['registerUrl' => action('Auth\AuthController@getRegister')]) !!}</h3>

    @include('includes._login-social')

    <div class="login-or">
        <hr/>
        <span>{!! trans('auth.login.or') !!}</span>
    </div>
    <form action="{!! action('Auth\AuthController@postLogin') !!}" method="POST">
        {!! Form::token() !!}
        <div class="row">
            <div class="col-md-12">
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('email', Input::old('email'), ['class' => 'form-control', 'tabindex' => 1, 'placeholder' => trans('auth.form.email.label')]) !!}
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
                        <input type="password" class="form-control" name="password" tabindex="2" placeholder="{!! trans('auth.form.password.label') !!}">
                    </div>
                    @if ($errors->has('password'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="form-group">
                    <button class="btn btn-lg btn-primary btn-block" tabindex="3" type="submit">{!! trans('buttons.login') !!}</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="pull-left">
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('remember', 'true', Input::old('remember', true)) !!}{!! trans('auth.form.remember') !!}
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="pull-right">
                    <p><a href="{!! action('Auth\PasswordController@getEmail') !!}">{!! trans('auth.form.forgot') !!}</a></p>
                </div>
            </div>
        </div>

        <hr/>

        <h3>{!! trans('auth.register.title') !!}</h3>
        <p>{!! trans('auth.register.advantages') !!}</p>
        @include('includes._login-social')
        <a class="btn btn-block btn-primary" href="#" style="margin-top: 10px">
            <i class="fa fa-envelope"></i> Create account with email
        </a>
    </form>
</div>