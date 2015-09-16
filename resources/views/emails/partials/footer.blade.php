<div class="footer">
    <table width="100%">
        <tr>
            <td class="content-block">

            </td>
        </tr>
        <tr>
            <td class="aligncenter content-block">
                View the {!! config('site.name') !!} <a href="#">Terms of Service</a> <!--TODO Add ToS link -->
            </td>
        </tr>
        <tr>
            <td class="aligncenter content-block">
                Questions? Email <a href="mailto:">{!! config('site.email.support') !!}</a><br>
                &copy; {!! Carbon::now()->year !!} <a href="{!! config('app.url') !!}">{!! config('site.name') !!}</a> | All rights reserved.<br>
                Acme Inc. 123 Van Ness, San Francisco 94102
            </td>
        </tr>
    </table>
</div>