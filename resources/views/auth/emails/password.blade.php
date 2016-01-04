@extends('emails.layouts.default')

@section('content')
    @parent
    <tr>
        <td class="content-block">
            <p>{!! trans('auth.reset.email.click') !!}</p>
            <p>{{ action('Auth\PasswordController@getReset', ['token' => $token]) }}</p>
        </td>
    </tr>
@endsection