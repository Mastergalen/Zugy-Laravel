<table class="table table-stripped">
    <thead>
        <tr>
            <th>ID</th>
            <th>{!! trans('order.date') !!}</th>
            <th>{!! trans('checkout.review.delivery-time') !!}</th>
            <th>{!! trans('checkout.total') !!}</th>
            <th>{!! trans('forms.status') !!}</th>
            <th>{!! trans('forms.action') !!}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $o)
            <tr>
                <td>#{{ $o['id'] }}</td>
                <td>{{ $o->order_placed }}</td>
                <td>@include('includes._order-delivery_time', ['delivery_time' => $o->delivery_time])</td>
                <td>{{ money_format("%i", $o->grandTotal) }}&euro;</td>
                <td>@include('includes.status.order-status', ['status' => $o['order_status']])</td>
                <td class="text-right">
                    <div class="btn-group">
                        <a href="{!! action('Admin\OrderController@show', $o->id) !!}" class="btn btn-default btn-xs"><i class="fa fa-eye"></i> {!! trans('buttons.view') !!}</a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6">
                {!! $orders->links() !!}
            </td>
        </tr>
    </tfoot>
</table>

