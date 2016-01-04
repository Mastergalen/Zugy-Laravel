<?php
if(!isset($type)) $type = 'label';
?>

@if($type == 'label')
    @if($status == 0)
        <span class="label label-warning">{!! trans('order.status.0') !!}</span>
    @elseif($status == 1)
        <span class="label label-primary">{!! trans('order.status.1') !!}</span>
    @elseif($status == 2)
        <span class="label label-primary">{!! trans('order.status.2') !!}</span>
    @elseif($status == 3)
        <span class="label label-success">{!! trans('order.status.3') !!}</span>
    @elseif($status == 4)
        <span class="label label-danger">{!! trans('order.status.4') !!}</span>
    @endif
@else
    @if($status == 0)
        <div class="callout callout-warning">{!! trans('order.status.0') !!}</div>
    @elseif($status == 1)
        <div class="callout callout-info">{!! trans('order.status.1') !!}</div>
    @elseif($status == 2)
        <div class="callout callout-info">{!! trans('order.status.2') !!}</div>
    @elseif($status == 3)
        <div class="callout callout-success">{!! trans('order.status.3') !!}</div>
    @elseif($status == 4)
        <div class="callout callout-danger">{!! trans('order.status.4') !!}</div>
    @endif
@endif