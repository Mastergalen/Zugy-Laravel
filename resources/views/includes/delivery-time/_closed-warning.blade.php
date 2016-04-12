@if(!DeliveryTime::isOpen(Carbon::now()))
    <div class="alert alert-warning">
        <p><strong>{!! trans('opening-times.closed') !!}</strong> {!! trans('opening-times.delivery-time') !!}</p>
        <p>{!! trans('opening-times.times') !!} <b>{!! trans('opening-times.when') !!}</b></p>
    </div>
@endif