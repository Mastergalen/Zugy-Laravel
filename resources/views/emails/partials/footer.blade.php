<div class="footer">
    <table width="100%">
        <tr>
            <td class="content-block">

            </td>
        </tr>
        <tr>
            <td class="aligncenter content-block">
                View the {!! config('site.name') !!} <a href="{!! localize_url('routes.terms-and-conditions') !!}">Terms of Service</a> <!--TODO Add ToS link -->
            </td>
        </tr>
        <tr>
            <td class="aligncenter content-block">
                Questions? Email <a href="mailto:">{!! config('site.email.support') !!}</a><br>
                &copy; {!! Carbon::now()->year !!} <a href="{!! config('app.url') !!}">{!! config('site.name') !!}</a> | All rights reserved.<br>
                {!! config('site.address') !!}
            </td>
        </tr>
    </table>
</div>