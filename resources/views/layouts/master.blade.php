@extends('layouts.barebones')

@section('body')
    @include('includes.header')

    <div class="main-content">
        @yield('content')
    </div>

    <footer>@include('includes.footer')</footer>
@endsection