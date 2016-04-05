<ul class="timeline">
    <?php $i = 0; ?>

    @foreach(ActivityLogParser::order($activity) as $a)
        <li @if($i % 2 != 0)class="timeline-inverted"@endif>
            <div class="timeline-badge {!! $a['type'] !!}"><i class="fa fa-{!! $a['icon'] !!}"></i></div>
            <div class="timeline-panel">
                <div class="timeline-heading">
                    <h4 class="timeline-title">{!! $a['title'] !!}</h4>
                </div>
                <p><small class="text-muted" data-toggle="tooltip" title="{!! $a['timestamp']->toDayDateTimeString() !!}"><i class="glyphicon glyphicon-time"></i> {!! $a['timestamp']->diffForHumans() !!}</small></p>
            </div>
        </li>
        <?php $i++; ?>
    @endforeach
</ul>