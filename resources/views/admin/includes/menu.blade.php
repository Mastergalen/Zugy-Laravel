<li>
    <a href="/admin">
        <i class="fa fa-dashboard"></i>
        <span>Dashboard</span>
    </a>
</li>
<li>
    <a href="{!! action('Admin\OrderController@index') !!}">
        <i class="fa fa-file-text"></i>
        <span>Orders</span>
        <?php $orderUnprocessedCount = \App\Order::unprocessed()->count() ?>

        @if($orderUnprocessedCount === 0)
            <span class="label label-success pull-right">{!! $orderUnprocessedCount !!}</span>
        @else
            <span class="label label-warning pull-right">{!! $orderUnprocessedCount !!}</span>
        @endif
    </a>
</li>
<li>
    <a href="/admin/catalogue"><i class="fa fa-book"></i> <span>Catalogue</span> </a>
</li>
<li>
    <a href="/admin/customers"><i class="fa fa-users"></i> <span>Customers</span> </a>
</li>

<li>
    <a href="#">
        <i class="fa fa-cog"></i>
        <span>Settings</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li><a href="/admin/settings/tax"><i class="fa">%</i> Tax</a></li>
    </ul>
</li>