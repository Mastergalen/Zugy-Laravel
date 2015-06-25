@section('title', 'Your account')

@extends('layouts.default')

@section('content')
    <div class="page-header">
        <h1>Your account</h1>
    </div>
    <pre>
        <?php var_dump(auth()->user()) ?>
    </pre>
@endsection


