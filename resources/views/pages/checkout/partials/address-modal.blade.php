<div class="modal fade" id="edit-address-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit address</h4>
            </div>
            <form>
                <input type="hidden" name="addressId">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">{!! trans('checkout.address.form.name') !!} <sup>*</sup> </label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label for="line_1">{!! trans('checkout.address.form.line_1') !!} <sup>*</sup> </label>
                        <input type="text" class="form-control" name="line_1">
                        <span class="help-text">{!! trans('checkout.address.form.line_1.desc') !!}</span>
                    </div>
                    <div class="form-group">
                        <label for="line_2">{!! trans('checkout.address.form.line_2') !!}</label>
                        <input type="text" class="form-control" name="line_2">
                        <span class="help-text">{!! trans('checkout.address.form.line_2.desc') !!}</span>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="zip">{!! trans('checkout.address.form.zip') !!} <sup>*</sup> </label>
                                <input type="text" class="form-control" name="postcode"
                                       placeholder="{!! trans('checkout.address.form.zip') !!}">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="city">{!! trans('checkout.address.form.town') !!} <sup>*</sup> </label>
                                <input type="text" class="form-control" name="city" placeholder="{!! trans('checkout.address.form.town') !!}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="country">{!! trans('checkout.address.form.country') !!} <sup>*</sup></label>
                        <select class="form-control" name="country" disabled>
                            <option value="ITA">{!! trans('checkout.address.form.country.italy') !!}</option>
                        </select>
                        <input type="hidden" name="country" value="ITA">
                    </div>
                    <div class="form-group">
                        <label for="InputAdditionalInformation">{!! trans('checkout.address.form.instructions') !!}</label>
                        <textarea rows="3" cols="26" name="delivery_instructions" class="form-control"></textarea>
                        <span class="help-text">{!! trans('checkout.address.form.instructions.desc') !!}</span>
                    </div>
                    <div class="form-group">
                        <label for="InputMobile">{!! trans('checkout.address.form.phone') !!} <sup>*</sup></label>
                        <input type="tel" name="phone" class="form-control">
                        <span class="help-text">{!! trans('checkout.address.form.phone.desc') !!}</span>
                    </div>
                </div>
                <div class="form-footer">
                    <button class="btn btn-danger btn-sm btn-delete" type="button">{!! trans('buttons.delete') !!}</button>
                    <button type="submit" class="btn btn-primary pull-right">{!! trans('buttons.save') !!}</button>
                </div>
            </form>
        </div>
    </div>
</div>