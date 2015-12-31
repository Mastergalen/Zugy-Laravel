@extends('layouts.master')

@section('content')
	<div id="container" class="container" style="padding-top: 60px">
        @include('includes.notifications')
		@yield('content')
	</div>
@overwrite