@if(Localization::getCurrentLocale() == 'it')
    @include('pages.terms-and-conditions.it')
@else
    @include('pages.terms-and-conditions.en')
@endif