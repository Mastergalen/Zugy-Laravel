@extends('admin.layouts.default')

@section('title', 'Catalogue')

@section('breadcrumb')
    <h2><i class="fa fa-book"></i> Catalogue</h2>
    <ol class="breadcrumb">
        <li>
            <a href="/admin">Home</a>
        </li>
        <li class="active">
            <strong>Catalogue</strong>
        </li>
    </ol>
@endsection

@section('content')
    <div class="ibox-content m-b-sm border-bottom">
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
                <a href="{!! action('Admin\CatalogueController@create') !!}" class="btn btn-default" style="margin-top: 23px">
                    <i class="fa fa-plus"></i> Add a product
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
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
                        <tr>
                            <td>1</td>
                            <td>
                                Example product 1
                            </td>
                            <td>
                                $50.00
                            </td>
                            <td>
                                1000
                            </td>
                            <td>
                                <span class="label label-primary">Enable</span>
                            </td>
                            <td class="text-right footable-visible footable-last-column">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                </div>
                            </td>
                        </tr>

                        @foreach($products as $p)
                            <tr>
                                <td>
                                    {{ $p['name'] }}
                                </td>
                                <td>{{ $p['stock'] }}</td>
                                <td>{{ $p['status'] }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn-white btn btn-xs">View</button>
                                        <button class="btn-white btn btn-xs">Edit</button>
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
        </div>
    </div>
@endsection