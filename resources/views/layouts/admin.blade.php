@extends('layouts.master')

@section('content')
    <div class="container">
        @include('includes.notifications')
        @include('includes.admin-menu')
        @yield('content')
    </div>
@overwrite