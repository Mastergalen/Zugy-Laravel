@if ($message = session('success'))
<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <h4>{{ trans('notifications.success') }}</h4>
    @if(is_array($message)) @foreach ($message as $m) {{ $m }} @endforeach
    @else {{ $message }} @endif
</div>
@endif
@if ($message = session('error'))
<div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <h4>{{ trans('notifications.error') }}</h4>
    @if(is_array($message)) @foreach ($message as $m) {{ $m }} @endforeach
    @else {{ $message }} @endif
</div>
@endif
@if ($message = session('warning'))
<div class="alert alert-warning alert-block">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <h4>{{ trans('notifications.warning') }}</h4>
    @if(is_array($message)) @foreach ($message as $m) {{ $m }} @endforeach
    @else {{ $message }} @endif
</div>
@endif
@if ($message = session('info'))
<div class="alert alert-info alert-block">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <h4>{{ trans('notifications.info') }}</h4>
    @if(is_array($message)) @foreach ($message as $m) {{ $m }} @endforeach
    @else {{ $message }}
    @endif
</div>
@endif