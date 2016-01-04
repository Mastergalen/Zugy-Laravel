@extends('admin.layouts.default')

@section('title', trans('admin.customers.title'))

@section('header')
    <h1><i class="fa fa-users"></i> {!! trans('admin.customers.title') !!}</h1>
@endsection

@section('breadcrumb')
    <li class="active">
        <strong>{!! trans('admin.customers.title') !!}</strong>
    </li>
@endsection

@section('content')
    <div class="box box-default">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-4">
                    <form action="" method="GET">
                        <div class="form-group">
                            <label class="control-label" for="product_name">{!! trans('admin.customers.name.label') !!}</label>
                            <div class="input-group">
                                <input type="text" name="name" placeholder="{!! trans('admin.customers.name.label') !!}" class="form-control">
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
                    <th>#</th>
                    <th>{!! trans('admin.customers.name.label') !!}</th>
                    <th>{!! trans('admin.orders.title') !!}</th>
                    <th>{!! trans('admin.customers.total') !!}</th>
                    <th>{!! trans('forms.action') !!}</th>
                </tr>
                </thead>
                <tbody>

                @foreach($customers as $c)
                    <tr>
                        <td>{{ $c['id'] }}</td>
                        <td><a href="{!! action('Admin\CustomerController@show', $c->id) !!}">{{ $c->name }}</a></td>
                        <td>{!! $c->orders->count() !!}</td>
                        <td>{!! money_format("%i", $c->orders->sum('grand_total')) !!}&euro;</td>
                        <td class="text-right">
                            <div class="btn-group">
                                <a href="{!! action('Admin\CustomerController@show', $c->id) !!}" class="btn btn-default btn-xs"><i class="fa fa-eye"></i> {!! trans('buttons.view') !!}</a>
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