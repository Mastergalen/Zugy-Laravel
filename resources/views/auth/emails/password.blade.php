@extends('emails.layouts.default')

@section('content')
    @parent
    <tr>
        <td class="content-block">
            Click here to reset your password:
        </td>
    </tr>
    <tr>
        <td class="content-block">
            {{ action('Auth\PasswordController@getReset', ['token' => $token]) }}
        </td>
    </tr>
@endsection