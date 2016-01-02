@extends('emails.layouts.default')

@section('content')
    @parent
    <tr>
        <td class="content-block">
            <p>Click here to reset your password:</p>
            <p>{{ action('Auth\PasswordController@getReset', ['token' => $token]) }}</p>
        </td>
    </tr>
@endsection