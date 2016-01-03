<table class="table table-stripped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Order Placed</th>
            <th>Total</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $o)
            <tr>
                <td>#{{ $o['id'] }}</td>
                <td>{{ $o->order_placed }}</td>
                <td>{{ money_format("%i", $o->grandTotal) }}&euro;</td>
                <td>@include('includes.status.order-status', ['status' => $o['order_status']])</td>
                <td class="text-right">
                    <div class="btn-group">
                        <a href="{!! action('Admin\OrderController@show', $o->id) !!}" class="btn btn-default btn-xs"><i class="fa fa-eye"></i> View</a>
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

