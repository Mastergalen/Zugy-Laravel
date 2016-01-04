@section('title', trans('pages.home.meta-title'))

@section('meta_description', trans('pages.home.meta_description'))

@extends('layouts.master')

@section('css')
    <style>
        .main-content {
            padding-bottom: 0px;
        }
    </style>
@endsection

@section('content')
    <div class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="/img/carousel/alcohol-drinks.jpg" style="margin:auto;">
                <div class="carousel-caption">
                    <div>
                        @include('includes.notifications')
                        <img src="/img/zugy-logo-dark.png" alt="Zugy Dark Logo"/>
                        <h4>{!! trans('pages.home.tagline') !!}</h4>

                        <form id="postcode-form">
                            <div class="input-group">
                                <input class="form-control" type="text" name="postcode"
                                       placeholder="{!! trans('forms.prompts.postcode') !!}" id="postcode-input" autocomplete="off"/>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit">{!! trans('buttons.shop-now') !!}</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row marketing">
            <div class="col-md-4">
                <i class="fa fa-map-marker"></i>
                <h4>{!! trans('pages.home.marketing.address.title') !!}</h4>
                <p>{!! trans('pages.home.marketing.address.desc') !!}</p>
            </div>
            <div class="col-md-4">
                <i class="fa fa-clock-o"></i>
                <h4>{!! trans('pages.home.marketing.time.title') !!}</h4>
                <p>{!! trans('pages.home.marketing.time.desc') !!}</p>
            </div>
            <div class="col-md-4">
                <i class="fa fa-truck"></i>
                <h4>{!! trans('pages.home.marketing.delivery.title') !!}</h4>
                <p>{!! trans('pages.home.marketing.delivery.desc') !!}</p>
            </div>
        </div>
    </div>

    <hr/>

    <div class="locations">
        <h4>{!! trans('pages.home.exclusive') !!}</h4>

        <p>{!! trans('pages.home.expansion') !!}</p>

        <div class="parallax">
            <span>{!! trans('pages.home.milan') !!}</span>
        </div>
    </div>
@endsection

@section('scripts')
<script>
$('#postcode-form').submit(function(e) {
    e.preventDefault();

    var zipCode = $('#postcode-input').val();

    postcode.check(zipCode);
});
</script>
@endsection