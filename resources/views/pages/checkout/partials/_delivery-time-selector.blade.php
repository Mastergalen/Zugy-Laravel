<div class="form-group">
    <label for="delivery_date">{!! trans('checkout.review.delivery-time.label') !!}</label>
    <select id="delivery_date" name="delivery_date" class="form-control" data-today="{!! Carbon::now()->toDateString() !!}" data-time-now="{!! Carbon::now()->format("H:i") !!}">
        <option value="asap">{!! trans('checkout.review.delivery-time.asap') !!}</option>
        <?php
        for($i = 0; $i < $days; $i++) {
            $currentDay = Carbon::now()->addDays($i);

            $dayThreshold = $currentDay->copy();
            $dayThreshold->hour = 23;
            $dayThreshold->minute = 5;
            if($i == 0 && $currentDay->gt($dayThreshold) ) continue; //Don't show day if time is after 23:05
            ?>
            <option value="{!! $currentDay->toDateString() !!}">{!! $currentDay->toFormattedDateString() !!}</option>
        <?php } ?>
    </select>
</div>
<div class="form-group" id="delivery_time-group" style="display: none">
    <label for="delivery_time">{!! trans('checkout.review.delivery-time.slot') !!}</label>
    <select name="delivery_time" id="delivery_time" class="form-control"></select>
</div>