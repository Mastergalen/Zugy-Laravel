<li>
    <a href="/admin">
        <i class="fa fa-dashboard"></i>
        <span>{!! trans('admin.dashboard.title') !!}</span>
    </a>
</li>
<li>
    <a href="{!! action('Admin\OrderController@index') !!}">
        <i class="fa fa-file-text"></i>
        <span>{!! trans('admin.orders.title') !!}</span>
        <?php $orderUnprocessedCount = \App\Order::incomplete()->count() ?>

        @if($orderUnprocessedCount === 0)
            <span class="label label-success pull-right">{!! $orderUnprocessedCount !!}</span>
        @else
            <span class="label label-warning pull-right">{!! $orderUnprocessedCount !!}</span>
        @endif
    </a>
</li>
<li>
    <a href="{!! action('Admin\CatalogueController@index') !!}"><i class="fa fa-book"></i> <span>{!! trans('admin.catalogue.title') !!}</span> </a>
</li>
<li>
    <a href="{!! action('Admin\CustomerController@index') !!}"><i class="fa fa-users"></i> <span>{!! trans('admin.customers.title') !!}</span> </a>
</li>

<li>
    <a href="{!! localize_url('routes.shop.index') !!}" target="_blank"><i class="fa fa-external-link"></i> <span>{!! trans('menu.shop') !!}</span></a>
</li>

<li>
    <a href="#">
        <i class="fa fa-cog"></i>
        <span>{!! trans('menu.admin.settings') !!}</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li><a href="/admin/settings/tax"><i class="fa">%</i> {!! trans('menu.admin.settings.tax') !!}</a></li>
    </ul>
</li>