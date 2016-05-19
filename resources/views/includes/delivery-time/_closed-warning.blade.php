@if(!DeliveryTime::isOpen(Carbon::now()))
    <div class="alert alert-warning">
        <p><strong>{!! trans('opening-times.closed') !!}</strong> {!! trans('opening-times.delivery-time') !!}</p>
        <p><b>{!! trans('opening-times.times') !!}</b></p>
        @include('includes.delivery-time._opening-times')
    </div>
@endif