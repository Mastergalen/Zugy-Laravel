<?php
if(!isset($type)) $type = 'label';
?>

@if($type == 'label')
    @if($status == 0)
        <span class="label label-default">Awaiting processing</span>
    @elseif($status == 1)
        <span class="label label-primary">Being processed</span>
    @elseif($status == 2)
        <span class="label label-primary">Out for delivery</span>
    @elseif($status == 3)
        <span class="label label-success">Delivered</span>
    @elseif($status == 4)
        <span class="label label-danger">Cancelled</span>
    @endif
@else
    @if($status == 0)
        <div class="callout callout-default">Awaiting processing</div>
    @elseif($status == 1)
        <div class="callout callout-info">Being processed</div>
    @elseif($status == 2)
        <div class="callout callout-info">Out for delivery</div>
    @elseif($status == 3)
        <div class="callout callout-success">Delivered</div>
    @elseif($status == 4)
        <div class="callout callout-danger">Cancelled</div>
    @endif
@endif