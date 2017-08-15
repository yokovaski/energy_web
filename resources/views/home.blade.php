@extends('layouts.app')

@section('content')
<div class="container col-sm-12">
    <div class="col-lg-8 col-lg-offset-2 col-md-12">
        <div class="row">
            <div class="col-sm-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Energieverbruik
                    </div>
                    <div class="panel-body">
                        <h4 id="usage_now">
                            {{ $lastMetric->usage_now }} Wh
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        Energieopwekking
                    </div>
                    <div class="panel-body">
                        <h4 id="solar_now">
                            {{ $lastMetric->solar_now }} Wh
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        Energielevering
                    </div>
                    <div class="panel-body">
                        <h4 id="redelivery_now">
                            {{ $lastMetric->redelivery_now }} Wh
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        Energieopname
                    </div>
                    <div class="panel-body">
                        <h4 id="intake_now">
                            {{ $lastMetric->intake_now }} Wh
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                Heading graph
                            </div>
                            <div class="panel-body">
                                <canvas id="chartjsTest" style="height:800px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                Heading metrics first
                            </div>
                            <div class="panel-body">
                                <canvas id="chartjsTest2"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                Heading metrics second
                            </div>
                            <div class="panel-body">
                                <canvas id="chartjsTest3"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <p class="panel-title pull-left">Dag gemiddelde</p>
                        <button data-toggle="collapse" data-target="#day-average" class="btn btn-xs btn-default pull-right" onclick="this.blur();">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                        <div class="clearfix"></div>
                    </div>
                    <div id="day-average" class="collapse in">
                        <div class="panel-body">
                            <table class="table table-responsive table-hover">
                                <tr>
                                    <th>
                                        Stroomopname
                                    </th>
                                    <td>
                                        {{ $lastMetric->avg_usage_now_today }} Wh
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Stroomopwekking
                                    </th>
                                    <td>
                                        {{ $lastMetric->avg_solar_now_today }} Wh
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Stroomlevering
                                    </th>
                                    <td>
                                        {{ $lastMetric->avg_redelivery_now_today }} Wh
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Gas
                                    </th>
                                    <td>
                                        {{ $lastMetric->avg_usage_gas_now_today }} Wh
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <p class="panel-title pull-left">Dag totaal</p>
                        <button data-toggle="collapse" data-target="#day-total" class="btn btn-xs btn-default pull-right" onclick="this.blur();">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                        <div class="clearfix"></div>
                    </div>
                    <div id="day-total" class="collapse in">
                        <div class="panel-body">
                            <table class="table table-responsive table-hover">
                                <tr>
                                    <th>
                                        Stroomopname
                                    </th>
                                    <td>
                                        {{ $lastMetric->sum_usage_now_today }} Wh
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Stroomopwekking
                                    </th>
                                    <td>
                                        {{ $lastMetric->sum_solar_now_today }} Wh
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Stroomlevering
                                    </th>
                                    <td>
                                        {{ $lastMetric->sum_redelivery_now_today }} Wh
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Gas
                                    </th>
                                    <td>
                                        {{ $lastMetric->sum_usage_gas_now_today }} Wh
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <p class="panel-title pull-left">Week gemiddelde</p>
                        <button data-toggle="collapse" data-target="#week-average" class="btn btn-xs btn-default pull-right" onclick="this.blur();">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                        <div class="clearfix"></div>
                    </div>
                    <div id="week-average" class="collapse">
                        <div class="panel-body">
                            <table class="table table-responsive table-hover">
                                <tr>
                                    <th>
                                        Stroomopname
                                    </th>
                                    <td>
                                        {{ $lastMetric->avg_usage_now_week }} Wh
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Stroomopwekking
                                    </th>
                                    <td>
                                        {{ $lastMetric->avg_solar_now_week }} Wh
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Stroomlevering
                                    </th>
                                    <td>
                                        {{ $lastMetric->avg_redelivery_now_week }} Wh
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Gas
                                    </th>
                                    <td>
                                        {{ $lastMetric->avg_usage_gas_now_week }} Wh
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <p class="panel-title pull-left">Week totaal</p>
                        <button data-toggle="collapse" data-target="#week-total" class="btn btn-xs btn-default pull-right" onclick="this.blur();">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                        <div class="clearfix"></div>
                    </div>
                    <div id="week-total" class="collapse">
                        <div class="panel-body">
                            <table class="table table-responsive table-hover">
                                <tr>
                                    <th>
                                        Stroomopname
                                    </th>
                                    <td>
                                        {{ $lastMetric->sum_usage_now_week }} Wh
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Stroomopwekking
                                    </th>
                                    <td>
                                        {{ $lastMetric->sum_solar_now_week}} Wh
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Stroomlevering
                                    </th>
                                    <td>
                                        {{ $lastMetric->sum_redelivery_now_week }} Wh
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Gas
                                    </th>
                                    <td>
                                        {{ $lastMetric->sum_usage_gas_now_week }} Wh
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <p class="panel-title pull-left">Meterstanden</p>
                        <button data-toggle="collapse" data-target="#meter-reading" class="btn btn-xs btn-default pull-right" onclick="this.blur();">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                        <div class="clearfix"></div>
                    </div>
                    <div id="meter-reading" class="collapse">
                        <div class="panel-body">
                            <table class="table table-responsive table-hover">
                                <tr>
                                    <th>
                                        Stroomopname hoog
                                    </th>
                                    <td>
                                        {{ $lastMetric->usage_total_high }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Stroomopname laag
                                    </th>
                                    <td>
                                        {{ $lastMetric->usage_total_low }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Stroomlevering hoog
                                    </th>
                                    <td>
                                        {{ $lastMetric->redelivery_total_high }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Stroomlevering laag
                                    </th>
                                    <td>
                                        {{ $lastMetric->redelivery_total_low }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Gas
                                    </th>
                                    <td>
                                        {{ $lastMetric->usage_gas_total }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script src="{{ asset('js/test.js') }}"></script>
@endsection
