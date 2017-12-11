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
                            {{ $metrics['usage_now'] / 1000 }} kW
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
                            {{ $metrics['solar_now'] / 1000 }} kW
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
                            {{ $metrics['redelivery_now'] / 1000 }} kW
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
                            {{ $metrics['intake_now'] / 1000 }} kW
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
                                <p class="panel-title pull-left">Energieverbruik</p>

                                <div class="btn-group pull-right" role="group" aria-label="...">
                                    <button type="button" class="chartRangeSelector btn-hour btn btn-default" onclick="this.blur();">Uur</button>
                                    <button type="button" class="chartRangeSelector btn-day btn btn-default active" onclick="this.blur();">Dag</button>
                                    <button type="button" class="chartRangeSelector btn-week btn btn-default" onclick="this.blur();">Week</button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body">
                                <canvas id="chartEnergyUse" style="height:800px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <p class="panel-title pull-left">Energieopwekking</p>

                                <div class="btn-group pull-right" role="group" aria-label="...">
                                    <button type="button" class="chartRangeSelector btn-hour btn btn-default" onclick="this.blur();">Uur</button>
                                    <button type="button" class="chartRangeSelector btn-day btn btn-default active" onclick="this.blur();">Dag</button>
                                    <button type="button" class="chartRangeSelector btn-week btn btn-default" onclick="this.blur();">Week</button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body">
                                <canvas id="chartEnergySolar" style="height:800px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <p class="panel-title pull-left">Energielevering</p>

                                <div class="btn-group pull-right" role="group" aria-label="...">
                                    <button type="button" class="chartRangeSelector btn-hour btn btn-default" onclick="this.blur();">Uur</button>
                                    <button type="button" class="chartRangeSelector btn-day btn btn-default active" onclick="this.blur();">Dag</button>
                                    <button type="button" class="chartRangeSelector btn-week btn btn-default" onclick="this.blur();">Week</button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body">
                                <canvas id="chartEnergyRedelivery" style="height:800px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <p class="panel-title pull-left">Energieopname</p>

                                <div class="btn-group pull-right" role="group" aria-label="...">
                                    <button type="button" class="chartRangeSelector btn-hour btn btn-default" onclick="this.blur();">Uur</button>
                                    <button type="button" class="chartRangeSelector btn-day btn btn-default active" onclick="this.blur();">Dag</button>
                                    <button type="button" class="chartRangeSelector btn-week btn btn-default" onclick="this.blur();">Week</button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body">
                                <canvas id="chartEnergyIntake" style="height:800px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-4">

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <p class="panel-title pull-left">Dag gemiddelde</p>
                        <button data-toggle="collapse" data-target="#day-average" class="btn btn-sm btn-default pull-right" onclick="this.blur();">
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
                                        {{ $metrics['avg_usage_now_today'] }} kWh
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Stroomopwekking
                                    </th>
                                    <td>
                                        {{ $metrics['avg_solar_now_today'] }} kWh
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Stroomlevering
                                    </th>
                                    <td>
                                        {{ $metrics['avg_redelivery_now_today'] }} kWh
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Gas
                                    </th>
                                    <td>
                                        {{ $metrics['avg_usage_gas_now_today'] }} m3
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <p class="panel-title pull-left">Dag totaal</p>
                        <button data-toggle="collapse" data-target="#day-total" class="btn btn-sm btn-default pull-right" onclick="this.blur();">
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
                                        {{ $metrics['total_usage_now_today'] }} kWh
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Stroomopwekking
                                    </th>
                                    <td>
                                        {{ $metrics['total_solar_now_today'] }} kWh
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Stroomlevering
                                    </th>
                                    <td>
                                        {{ $metrics['total_redelivery_now_today'] }} kWh
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Gas
                                    </th>
                                    <td>
                                        {{ $metrics['total_usage_gas_now_today'] }} m3
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <p class="panel-title pull-left">Week gemiddelde</p>
                        <button data-toggle="collapse" data-target="#week-average" class="btn btn-sm btn-default pull-right" onclick="this.blur();">
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
                                        {{ $metrics['avg_usage_now_days'] }} kWh
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Stroomopwekking
                                    </th>
                                    <td>
                                        {{ $metrics['avg_solar_now_days'] }} kWh
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Stroomlevering
                                    </th>
                                    <td>
                                        {{ $metrics['avg_redelivery_now_days'] }} kWh
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Gas
                                    </th>
                                    <td>
                                        {{ $metrics['avg_usage_gas_now_days'] }} m3
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <p class="panel-title pull-left">Week totaal</p>
                        <button data-toggle="collapse" data-target="#week-total" class="btn btn-sm btn-default pull-right" onclick="this.blur();">
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
                                        {{ $metrics['total_usage_now_days'] }} kWh
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Stroomopwekking
                                    </th>
                                    <td>
                                        {{ $metrics['total_solar_now_days'] }} kWh
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Stroomlevering
                                    </th>
                                    <td>
                                        {{ $metrics['total_redelivery_now_days'] }} kWh
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Gas
                                    </th>
                                    <td>
                                        {{ $metrics['total_usage_gas_now_days'] }} m3
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <p class="panel-title pull-left">Meterstanden</p>
                        <button data-toggle="collapse" data-target="#meter-reading" class="btn btn-sm btn-default pull-right" onclick="this.blur();">
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
                                        {{ $metrics['usage_total_high'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Stroomopname laag
                                    </th>
                                    <td>
                                        {{ $metrics['usage_total_low'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Stroomlevering hoog
                                    </th>
                                    <td>
                                        {{ $metrics['redelivery_total_high'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Stroomlevering laag
                                    </th>
                                    <td>
                                        {{ $metrics['redelivery_total_low'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Gas
                                    </th>
                                    <td>
                                        {{ $metrics['usage_gas_total'] }}
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
