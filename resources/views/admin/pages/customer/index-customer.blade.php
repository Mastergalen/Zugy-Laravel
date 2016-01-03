@extends('admin.layouts.default')

@section('title', 'Customer')

@section('header')
    <h1><i class="fa fa-users"></i> Customers</h1>
@endsection

@section('breadcrumb')
    <li class="active">
        <strong>Customers</strong>
    </li>
@endsection

@section('content')
    <div class="box box-default">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-4">
                    <form action="" method="GET">
                        <div class="form-group">
                            <label class="control-label" for="product_name">Customer Name</label>
                            <div class="input-group">
                                <input type="text" name="name" placeholder="Customer Name" class="form-control">
                                <span class="input-group-btn">
                                    <button class="btn btn-default">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if(request()->has('name'))
                <div class="alert alert-info">
                    Searching for <b>{{ request('name') }}</b>. {{ count($customers) }} result(s) found.
                </div>
            @endif
        </div>

        <div class="box-body no-padding">
            <table class="table table-stripped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                </tr>
                </thead>
                <tbody>

                @foreach($customers as $c)
                    <tr>
                        <td>{{ $c['id'] }}</td>
                        <td><a href="{!! action('Admin\CustomerController@show', $c->id) !!}">{{ $c->name }}</a></td>
                        <td class="text-right">
                            <div class="btn-group">
                                <a href="{!! action('Admin\CustomerController@show', $c->id) !!}" class="btn btn-default btn-xs">View</a>
                            </div>
                        </td>

                    </tr>
                @endforeach

                </tbody>
                <tfoot>
                <tr>
                    <td colspan="6">
                        {!! $customers->render() !!}
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection