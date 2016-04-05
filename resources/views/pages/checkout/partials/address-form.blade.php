<div class="row" @if($type == 'billing') id="billing-address" style="display:none" @endif>
    <div class="col-xs-12 col-sm-6">
        <div class="form-group">
            <label for="{!! $type !!}[name]">{!! trans('checkout.address.form.name') !!} <sup>*</sup> </label>
            @if(auth()->check())
                {!! Form::text($type . "[name]", Input::old($type . "name", auth()->user()->name), ['class' => 'form-control inputName', 'placeholder' => trans('checkout.address.form.name'), 'data-fv-notempty' => 'true']) !!}
            @else
                {!! Form::text($type . "[name]", Input::old($type . "name"), ['class' => 'form-control inputName', 'placeholder' => "Full Name", 'data-fv-notempty' => 'true']) !!}
            @endif
        </div>
        <div class="form-group">
            <label for="{!! $type !!}[line_1]">{!! trans('checkout.address.form.line_1') !!} <sup>*</sup> </label>
            <input type="text" class="form-control inputLine1" name="{!! $type !!}[line_1]" >
            <span class="help-text">{!! trans('checkout.address.form.line_1.desc') !!}</span>
        </div>
        <div class="form-group">
            <label for="{!! $type !!}[line_2]">{!! trans('checkout.address.form.line_2') !!}</label>
            <input type="text" class="form-control inputLine2" name="{!! $type !!}[line_2]">
            <span class="help-text">{!! trans('checkout.address.form.line_2.desc') !!}</span>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="{!! $type !!}[zip]">{!! trans('checkout.address.form.zip') !!} <sup>*</sup> </label>
                    <input type="text" class="form-control inputPostcode" name="{!! $type !!}[postcode]" placeholder="{!! trans('checkout.address.form.zip') !!}" >
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="{!! $type !!}[city]">{!! trans('checkout.address.form.town') !!} <sup>*</sup> </label>
                    <input type="text" class="form-control inputCity" name="{!! $type !!}[city]" placeholder="{!! trans('checkout.address.form.town') !!}" >
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="country">{!! trans('checkout.address.form.country') !!} <sup>*</sup></label>
            @if($type == 'delivery')
                <select class="form-control" name="{!! $type !!}[country]" disabled>
                    <option value="ITA">{!! trans('checkout.address.form.country.italy') !!}</option>
                </select>
                <input type="hidden" name="{!! $type !!}[country]" value="ITA">
            @else
                <!-- TODO Show country names in Italian -->
                {!! Form::select($type. "[country]", Countries::pluck('name', 'iso_3166_3'), 'ITA', ['class' => 'form-control']) !!}
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-6">
        @if($type == 'delivery')
            <div class="form-group">
                <label for="InputAdditionalInformation">{!! trans('address.form.instructions') !!}</label>
                <textarea rows="3" cols="26" name="{!! $type !!}[delivery_instructions]" class="form-control"></textarea>
                <span class="help-text">{!! trans('checkout.address.form.instructions.desc') !!}</span>
            </div>
            <div class="form-group">
                <label for="InputMobile">{!! trans('checkout.address.form.phone') !!} <sup>*</sup></label>
                <input type="tel" name="{!! $type !!}[phone]" class="form-control" >
                <span class="help-text">{!! trans('checkout.address.form.phone.desc') !!}</span>
            </div>
        @endif
        <div class="form-group">
            <div class="checkbox">
                <label for="">
                    <input type="checkbox" name="{!! $type !!}[default]" checked> {!! trans('checkout.address.form.default') !!}
                </label>
            </div>
        </div>
    </div>
</div>