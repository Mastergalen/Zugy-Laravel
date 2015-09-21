@if($status == 0)
    <span class="label label-danger">Unpaid</span>
@elseif($status == 1)
    <span class="label label-success">Paid</span>
@elseif($status == 2)
    <span class="label label-primary">Refunded</span>
@elseif($status == 3)
    <span class="label label-warning">Payment on delivery</span>
@endif