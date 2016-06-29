<p>{!! Carbon::now()->startOfWeek()->formatLocalized('%a') !!} - {!! Carbon::now()->endOfWeek()->formatLocalized('%a') !!}: {!! Carbon::now()->hour(13)->minute(0)->formatLocalized("%R") !!} - {!! Carbon::now()->hour(1)->minute(0)->formatLocalized("%R") !!}</p>
{{--
Mon-Thu 13:00-01:00
Fri-Sun: 13:00-02:00
<p>{!! Carbon::now()->startOfWeek()->formatLocalized('%a') !!} - {!! Carbon::now()->startOfWeek()->addDay(3)->formatLocalized('%a') !!}: {!! Carbon::now()->hour(13)->minute(0)->formatLocalized("%R") !!} - {!! Carbon::now()->hour(1)->minute(0)->formatLocalized("%R") !!}</p>
<p>{!! Carbon::now()->startOfWeek()->addDay(4)->formatLocalized('%a') !!} - {!! Carbon::now()->endOfWeek()->formatLocalized('%a') !!}: {!! Carbon::now()->hour(13)->minute(0)->formatLocalized("%R") !!} - {!! Carbon::now()->hour(2)->minute(0)->formatLocalized("%R") !!}</p>
--}}