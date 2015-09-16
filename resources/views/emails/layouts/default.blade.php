@extends('emails.layouts.master')

@section('content')
<table class="main" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td class="content-wrap">
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="content-block aligncenter">
                        <a href="{!! config('app.url') !!}"><img src="{!! config('site.email.logo_path') !!}" alt="Zugy logo"></a>
                    </td>
                </tr>
                @yield('content')
            </table>
        </td>
    </tr>
</table>
@overwrite
