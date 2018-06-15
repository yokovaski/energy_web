@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-3 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white font-weight-bold">
                    Energieverbruik
                </div>
                <div class="card-body">
                    <h4 id="usage_now">
                        {{ $metrics['usage_now'] / 1000 }} kW
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-sm-3 mb-4">
            <div class="card">
                <div class="card-header bg-success text-white font-weight-bold">
                    Energieopwekking
                </div>
                <div class="card-body">
                    <h4 id="solar_now">
                        {{ $metrics['solar_now'] / 1000 }} kW
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-sm-3 mb-4">
            <div class="card">
                <div class="card-header bg-warning text-white font-weight-bold">
                    Energielevering
                </div>
                <div class="card-body">
                    <h4 id="redelivery_now">
                        {{ $metrics['redelivery_now'] / 1000 }} kW
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-sm-3 mb-4">
            <div class="card">
                <div class="card-header bg-danger text-white font-weight-bold">
                    Energieopname
                </div>
                <div class="card-body">
                    <h4 id="intake_now">
                        {{ $metrics['intake_now'] / 1000 }} kW
                    </h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white font-weight-bold">
                            Energieverbruik

                            <div class="btn-group btn-group-sm float-right" role="group">
                                <button type="button" class="chartRangeSelector btn-now btn btn-secondary" onclick="this.blur();">Nu</button>
                                <button type="button" class="chartRangeSelector btn-hour btn btn-secondary active" onclick="this.blur();">Uur</button>
                                <button type="button" class="chartRangeSelector btn-day btn btn-secondary" onclick="this.blur();">Dag</button>
                                <button type="button" class="chartRangeSelector btn-week btn btn-secondary" onclick="this.blur();">Week</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="chartEnergyUse"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white font-weight-bold">
                            Energieopwekking

                            <div class="btn-group btn-group-sm float-right" role="group" aria-label="...">
                                <button type="button" class="chartRangeSelector btn-now btn btn-secondary" onclick="this.blur();">Nu</button>
                                <button type="button" class="chartRangeSelector btn-hour btn btn-secondary active" onclick="this.blur();">Uur</button>
                                <button type="button" class="chartRangeSelector btn-day btn btn-secondary" onclick="this.blur();">Dag</button>
                                <button type="button" class="chartRangeSelector btn-week btn btn-secondary" onclick="this.blur();">Week</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="chartEnergySolar"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header bg-warning text-white font-weight-bold">
                            Energielevering

                            <div class="btn-group btn-group-sm float-right" role="group" aria-label="...">
                                <button type="button" class="chartRangeSelector btn-now btn btn-secondary" onclick="this.blur();">Nu</button>
                                <button type="button" class="chartRangeSelector btn-hour btn btn-secondary active" onclick="this.blur();">Uur</button>
                                <button type="button" class="chartRangeSelector btn-day btn btn-secondary" onclick="this.blur();">Dag</button>
                                <button type="button" class="chartRangeSelector btn-week btn btn-secondary" onclick="this.blur();">Week</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="chartEnergyRedelivery"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header bg-danger text-white font-weight-bold">
                            Energieopname

                            <div class="btn-group btn-group-sm float-right" role="group" aria-label="...">
                                <button type="button" class="chartRangeSelector btn-now btn btn-secondary" onclick="this.blur();">Nu</button>
                                <button type="button" class="chartRangeSelector btn-hour btn btn-secondary active" onclick="this.blur();">Uur</button>
                                <button type="button" class="chartRangeSelector btn-day btn btn-secondary" onclick="this.blur();">Dag</button>
                                <button type="button" class="chartRangeSelector btn-week btn btn-secondary" onclick="this.blur();">Week</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            <canvas id="chartEnergyIntake"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-4">

            <div class="card mb-4">
                <div class="card-header bg-info text-white font-weight-bold">
                    Dag gemiddelde
                    <button data-toggle="collapse" data-target="#day-average" aria-expanded="false" class="btn btn-sm btn-default float-right" onclick="this.blur();">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
                <div id="day-average" class="collapse show">
                    <div class="card-body">
                        <table class="table table-hover">
                            <tr>
                                <th>
                                    Stroomopname
                                </th>
                                <td>
                                    {{ $metrics['avg_usage_now_today'] }} kW
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Stroomopwekking
                                </th>
                                <td>
                                    {{ $metrics['avg_solar_now_today'] }} kW
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Stroomlevering
                                </th>
                                <td>
                                    {{ $metrics['avg_redelivery_now_today'] }} kW
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
            <div class="card mb-4">
                <div class="card-header bg-info text-white font-weight-bold">
                    Dag totaal
                    <button data-toggle="collapse" data-target="#day-total" class="btn btn-sm btn-default float-right" onclick="this.blur();">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
                <div id="day-total" class="collapse show">
                    <div class="panel-body">
                        <table class="table table-hover">
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
                                    {{ $metrics['total_solar_today'] }} kWh
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
            <div class="card mb-4">
                <div class="card-header bg-info text-white font-weight-bold">
                    Week gemiddelde
                    <button data-toggle="collapse" data-target="#week-average" class="btn btn-sm btn-default float-right" onclick="this.blur();">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
                <div id="week-average" class="collapse">
                    <div class="card-body">
                        <table class="table table-hover">
                            <tr>
                                <th>
                                    Stroomopname
                                </th>
                                <td>
                                    {{ $metrics['avg_usage_now_days'] }} kW
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Stroomopwekking
                                </th>
                                <td>
                                    {{ $metrics['avg_solar_now_days'] }} kW
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Stroomlevering
                                </th>
                                <td>
                                    {{ $metrics['avg_redelivery_now_days'] }} kW
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
            <div class="card mb-4">
                <div class="card-header bg-info text-white font-weight-bold">
                    Week totaal
                    <button data-toggle="collapse" data-target="#week-total" class="btn btn-sm btn-default float-right" onclick="this.blur();">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
                <div id="week-total" class="collapse">
                    <div class="card-body">
                        <table class="table table-hover">
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
                                    {{ $metrics['total_solar_days'] }} kWh
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
            <div class="card mb-4">
                <div class="card-header bg-info text-white font-weight-bold">
                    Meterstanden
                    <button data-toggle="collapse" data-target="#meter-reading" class="btn btn-sm btn-default float-right" onclick="this.blur();">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
                <div id="meter-reading" class="collapse">
                    <div class="card-body">
                        <table class="table table-hover">
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
@endsection

@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <script src="{{ asset('js/home.js') }}"></script>
@endsection
