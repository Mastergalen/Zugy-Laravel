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
                        <label for="name">Full Name <sup>*</sup> </label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label for="line_1">Address Line 1 <sup>*</sup> </label>
                        <input type="text" class="form-control" name="line_1">
                        <span class="help-text">House name/number and street, P.O. box, company name, c/o</span>
                    </div>
                    <div class="form-group">
                        <label for="line_2">Address Line 2</label>
                        <input type="text" class="form-control" name="line_2">
                        <span class="help-text">Apartment, suite, unit, building, floor, etc.</span>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="zip">Zip / Postal Code <sup>*</sup> </label>
                                <input type="text" class="form-control" name="postcode"
                                       placeholder="Zip / Postal Code">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="city">Town/City <sup>*</sup> </label>
                                <input type="text" class="form-control" name="city" placeholder="Town/City">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="country">Country <sup>*</sup></label>
                        <select class="form-control" name="country" disabled>
                            <option value="ITA">Italy</option>
                        </select>
                        <input type="hidden" name="country" value="ITA">
                    </div>
                    <div class="form-group">
                        <label for="InputAdditionalInformation">Delivery Instructions</label>
                        <textarea rows="3" cols="26" name="delivery_instructions" class="form-control"></textarea>
                        <span class="help-text">Additional information for our driver</span>
                    </div>
                    <div class="form-group">
                        <label for="InputMobile">Phone <sup>*</sup></label>
                        <input type="tel" name="phone" class="form-control">
                        <span class="help-text">In case our driver needs to contact you for delivery.</span>
                    </div>
                </div>
                <div class="form-footer">
                    <button class="btn btn-danger btn-sm btn-delete" type="button">Remove address</button>
                    <button type="submit" class="btn btn-primary pull-right">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>