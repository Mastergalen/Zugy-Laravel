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
                    <div class="form-group">
                        <label class="control-label" for="product_name">Product Name</label>
                        <input type="text" id="product_name" name="product_name" value="" placeholder="Product Name"
                               class="form-control">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="control-label" for="price">Price</label>
                        <input type="text" id="price" name="price" value="" placeholder="Price" class="form-control">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1" selected="">Enabled</option>
                            <option value="0">Disabled</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-2">
                    <a href="{!! action('Admin\CatalogueController@create') !!}" class="btn btn-default"
                       style="margin-top: 23px">
                        <i class="fa fa-plus"></i> Add a product
                    </a>
                </div>
            </div>
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
                        <td>{{ $p->getDescription(auth()->user()->settings()->language)->title }}</td>
                        <td>{{ $p['price'] }} &#8364;</td>
                        <td>{{ $p['stock_quantity'] }}</td>
                        <td>{{ $p['status'] }}</td>
                        <td class="text-right">
                            <div class="btn-group">
                                <a href="{!! Localization::getURLFromRouteNameTranslated(auth()->user()->language_code, 'routes.product', ['slug' => $p['description'][0]['slug']]) !!}" class="btn btn-default btn-xs">View</a>
                                <button class="btn btn-default btn-xs">Edit</button>
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