@if(Localization::getCurrentLocale() == 'it')
    @include('pages.privacy-policy.it')
@else
    @include('pages.privacy-policy.en')
@endif