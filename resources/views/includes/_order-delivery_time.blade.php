@if($delivery_time != null)
    {!! $delivery_time->toFormattedDateString() !!} | {!! $delivery_time->format("H:i") !!} - {!! $delivery_time->addHours(1)->format("H:i") !!}
@else
    {!! trans('checkout.review.delivery-time.asap') !!}
@endif