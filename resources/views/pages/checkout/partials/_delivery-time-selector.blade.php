<div class="form-group">
    <label for="delivery_date">{!! trans('checkout.review.delivery-time.label') !!}</label>
    <select id="delivery_date" name="delivery_date" class="form-control" data-today="{!! Carbon::now()->toDateString() !!}" data-time-now="{!! Carbon::now()->format("H:i") !!}">
        <option value="asap">{!! trans('checkout.review.delivery-time.asap') !!}</option>
        @foreach(DeliveryTime::daySelect(8) as $currentDay)
            <option value="{!! $currentDay->toDateString() !!}">{!! $currentDay->toFormattedDateString() !!}</option>
        @endforeach
    </select>
    @if(!DeliveryTime::isOpen(Carbon::now()))
        <p class="help-block">{!! trans('opening-times.prompt-select') !!}</p>
    @endif
</div>
<div class="form-group" id="delivery_time-group" style="display: none">
    <label for="delivery_time">{!! trans('checkout.review.delivery-time.slot') !!}</label>
    <select name="delivery_time" id="delivery_time" class="form-control"></select>
</div>