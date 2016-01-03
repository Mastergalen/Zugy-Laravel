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
        <!--
    <li>
        <div class="timeline-badge"><i class="fa fa-check"></i></div>
        <div class="timeline-panel">
            <div class="timeline-heading">
                <h4 class="timeline-title">Order placed</h4>
                <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 11 hours ago via Twitter</small></p>
            </div>
        </div>
    </li>
    <li class="timeline-inverted">
        <div class="timeline-badge warning"><i class="fa fa-ellipsis-h"></i></div>
        <div class="timeline-panel">
            <div class="timeline-heading">
                <h4 class="timeline-title">Processing</h4>
            </div>
            <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 11 hours ago via Twitter</small></p>
        </div>
    </li>
    <li>
        <div class="timeline-badge primary"><i class="fa fa-truck"></i></div>
        <div class="timeline-panel">
            <div class="timeline-heading">
                <h4 class="timeline-title">Out for delivery</h4>
            </div>
            <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 11 hours ago via Twitter</small></p>
        </div>
    </li>
    <li class="timeline-inverted">
        <div class="timeline-badge success"><i class="fa fa-check"></i></div>
        <div class="timeline-panel">
            <div class="timeline-heading">
                <h4 class="timeline-title">Delivered</h4>
            </div>
            <div class="timeline-body">
                <p>Thanks for shopping with us!</p>
            </div>
        </div>
    </li>
    -->
</ul>