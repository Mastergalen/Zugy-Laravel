@extends('admin.layouts.default')

@section('title', 'Catalogue')

@section('header')
    <h1><i class="fa fa-book"></i> Catalogue</h1>
@endsection

@section('breadcrumb')
    <li class="active">
        <strong>Catalogue</strong>
    </li>
@endsection

@section('content')
    <div class="box box-default">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-4">
                    <form action="" method="GET">
                        <div class="form-group">
                            <label class="control-label" for="product_name">Product Name</label>
                            <div class="input-group">
                                <input type="text" id="product_name" name="product_name" value=""
                                       placeholder="Product Name"
                                       class="form-control">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default"><i class="fa fa-search"></i>
                                                    </button>
                                                </span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-2">
                    <a href="{!! action('Admin\CatalogueController@create') !!}" class="btn btn-primary"
                       style="margin-top: 23px">
                        <i class="fa fa-plus"></i> Add a product
                    </a>
                </div>
            </div>

            @if(request()->has('product_name'))
                <div class="alert alert-info">
                    Searching for <b>{{ request('product_name') }}</b>. {{ count($products) }} result(s) found.
                </div>
            @endif
        </div>

        <div class="box-body no-padding">
            <table class="table table-stripped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                @foreach($products as $p)
                    <tr>
                        <td>{{ $p['id'] }}</td>
                        <td><a href="{!! action('Admin\CatalogueController@edit', $p->id) !!}">{{ $p->title }}</a></td>
                        <td>{{ $p['price'] }} &#8364;</td>
                        <td>{{ $p['stock_quantity'] }}</td>
                        <td>{{ $p['status'] }}</td>
                        <td class="text-right">
                            <div class="btn-group">
                                <a href="{!! $p->getUrl() !!}" class="btn btn-default btn-xs"><i class="fa fa-eye"></i> View</a>
                                <a href="{!! action('Admin\CatalogueController@edit', $p->id) !!}" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i> Edit</a>
                            </div>
                        </td>

                    </tr>
                @endforeach

                </tbody>
                <tfoot>
                <tr>
                    <td colspan="6">
                        {!! $products->render() !!}
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection