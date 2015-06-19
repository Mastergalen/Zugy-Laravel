@extends('layouts.master')

@section('content')
	<div class="container">
        @include('includes.notifications')
		@yield('content')
	</div>
@overwrite