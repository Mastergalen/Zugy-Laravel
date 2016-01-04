@if($status == 0)
    <span class="label label-danger">{!! trans('status.payment.0') !!}</span>
@elseif($status == 1)
    <span class="label label-success">{!! trans('status.payment.1') !!}</span>
@elseif($status == 2)
    <span class="label label-primary">{!! trans('status.payment.2') !!}</span>
@elseif($status == 3)
    <span class="label label-warning">{!! trans('status.payment.3') !!}</span>
@endif