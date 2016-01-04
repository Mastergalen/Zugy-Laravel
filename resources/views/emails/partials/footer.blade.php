<div class="footer">
    <table width="100%">
        <tr>
            <td class="aligncenter content-block">
                {!! trans('email.footer.tos', [
                    'name' => config('site.name'),
                    'tosUrl' => localize_url('routes.terms-and-conditions')
                ]) !!}
            </td>
        </tr>
        <tr>
            <td class="aligncenter content-block">
                {!! trans('email.footer.questions', ['email' => config('site.email.support')]) !!}<br>
                &copy; {!! Carbon::now()->year !!} <a href="{!! config('app.url') !!}">{!! config('site.name') !!}</a> | {!! trans('footer.rights-reserved') !!}<br>
                {!! config('site.address') !!}
            </td>
        </tr>
    </table>
</div>