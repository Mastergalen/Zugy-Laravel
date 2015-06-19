@section('title', 'Protected Area - Please log in')
@extends('errors.default')

@section('content')
<div class="alert alert-warning">
	<h2>Protected area</h2>
	<p>Please <button class="btn btn-default signin"><i class="fa fa-sign-in"></i> Sign in</button> to access this area.</p>
</div>
@overwrite