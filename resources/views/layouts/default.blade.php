@extends('layouts.master')

@section('content')
	<div class="container" style="margin-top: 60px">
        @include('includes.notifications')
		@yield('content')
	</div>
@overwrite