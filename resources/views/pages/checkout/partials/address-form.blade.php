<div class="row" @if($type == 'billing') id="billing-address" style="display:none" @endif>
    <div class="col-xs-12 col-sm-6">
        <div class="form-group">
            <label for="{!! $type !!}[name]">Full Name <sup>*</sup> </label>
            {!! Form::text($type . "[name]", Input::old($type . "name", auth()->user()->name), ['class' => 'form-control inputName', 'placeholder' => "Full Name", 'data-fv-notempty' => 'true']) !!}
        </div>
        <div class="form-group">
            <label for="{!! $type !!}[line_1]">Address Line 1 <sup>*</sup> </label>
            <input type="text" class="form-control inputLine1" name="{!! $type !!}[line_1]" >
            <span class="help-text">House name/number and street, P.O. box, company name, c/o</span>
        </div>
        <div class="form-group">
            <label for="{!! $type !!}[line_2]">Address Line 2</label>
            <input type="text" class="form-control inputLine2" name="{!! $type !!}[line_2]">
            <span class="help-text">Apartment, suite, unit, building, floor, etc.</span>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="{!! $type !!}[zip]">Zip / Postal Code <sup>*</sup> </label>
                    <input type="text" class="form-control inputPostcode" name="{!! $type !!}[postcode]" placeholder="Zip / Postal Code" >
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="{!! $type !!}[city]">Town/City <sup>*</sup> </label>
                    <input type="text" class="form-control inputCity" name="{!! $type !!}[city]" placeholder="Town/City" >
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="country">Country <sup>*</sup></label>
            @if($type == 'delivery')
                <select class="form-control" name="{!! $type !!}[country]" disabled>
                    <option value="ITA">Italy</option>
                </select>
                <input type="hidden" name="{!! $type !!}[country]" value="ITA">
            @else
                <!-- Show country names in Italian -->
                {!! Form::select($type. "[country]", Countries::lists('name', 'iso_3166_3'), 'ITA', ['class' => 'form-control']) !!}
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-6">
        @if($type == 'delivery')
            <div class="form-group">
                <label for="InputAdditionalInformation">Delivery Instructions</label>
                <textarea rows="3" cols="26" name="{!! $type !!}[delivery_instructions]" class="form-control"></textarea>
                <span class="help-text">Additional information for our driver</span>
            </div>
            <div class="form-group">
                <label for="InputMobile">Phone <sup>*</sup></label>
                <input type="tel" name="{!! $type !!}[phone]" class="form-control" >
                <span class="help-text">In case our driver needs to contact you for delivery.</span>
            </div>
        @endif
        <div class="form-group">
            <div class="checkbox">
                <label for="">
                    <input type="checkbox" name="{!! $type !!}[default]" checked> Use this address as default for future
                    orders
                </label>
            </div>
        </div>
    </div>
</div>