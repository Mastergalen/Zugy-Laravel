@extends('admin.layouts.default')

@section('title', trans('admin.dashboard.title'))

@section('header')
    <h1><i class="fa fa-dashboard"></i> {!! trans('admin.dashboard.title') !!}</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-offset-3 col-md-2">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $orders->incomplete()->count() }}</h3>

                    <p>{!! trans('admin.incomplete-orders') !!}</p>
                </div>
                <div class="icon">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                {{--
                <a href="{!! action('Admin\OrderController@index', ['filter' => 'incomplete']) !!}" class="small-box-footer">
                    {!! trans('buttons.more-info') !!} <i class="fa fa-arrow-circle-right"></i>
                </a>
                --}}
            </div>
        </div>
        <!-- ./col -->
        <div class="col-md-2">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ money_format("%i", $revenueYesterday) }}&euro;</h3>

                    <p>{!! trans('admin.revenue-yesterday') !!}</p>
                </div>
                <div class="icon">
                    <i class="fa fa-dollar"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-md-2">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ money_format("%i", $revenueThisMonth) }}&euro;</h3>

                    <p>{!! trans('admin.revenue-this-month') !!}</p>
                </div>
                <div class="icon">
                    <i class="fa fa-dollar"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Last 30 days</h3>
                </div>
                <div class="box-body">
                    <canvas id="chart-30d"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var chart30d = $('#chart-30d');
        var myChart = new Chart(chart30d, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chart['30-days']['x']) !!},
                datasets: [{
                    label: "Revenue",
                    data: {!! json_encode($chart['30-days']['y']) !!},
                    backgroundColor: "rgba(151,187,205,0.5)",
                }]
            },
            options: {
                legend: {
                    display: false
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            return Number(tooltipItem.yLabel).toFixed(2).replace(',', '.') + "\u20AC";
                        }
                    }

                },
                scales: {
                    yAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Revenue (Euro)'
                        },
                        ticks: {
                            beginAtZero: true,
                            callback: function (tickValue, index, ticks) {
                                return Number(tickValue).toFixed(2).replace(',','.') + '\u20AC';
                            }
                        }
                    }]
                }
            }
        });
    </script>
@endsection