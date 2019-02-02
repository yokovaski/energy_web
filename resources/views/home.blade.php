@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-text text-center"><small class="text-primary font-weight-bold">Verbruik</small></h5>
                    <h1 id="usage_now" class="text-center font-weight-bold text-secondary">
                        {{ $metrics['usage_now'] / 1000 }}
                    </h1>
                    <h4 class="text-center text-muted"><small>kW</small></h4>
                </div>
            </div>
        </div>
        <div class="col-sm-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-text text-center"><small class="text-success font-weight-bold">Opwekking</small></h5>
                    <h1 id="usage_now" class="text-center font-weight-bold text-secondary">
                        {{ $metrics['solar_now'] / 1000 }}
                    </h1>
                    <h4 class="text-center text-muted"><small>kW</small></h4>
                </div>
            </div>
        </div>
        <div class="col-sm-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-text text-center"><small class="text-warning font-weight-bold">Levering</small></h5>
                    <h1 id="usage_now" class="text-center font-weight-bold text-secondary">
                        {{ $metrics['redelivery_now'] / 1000 }}
                    </h1>
                    <h4 class="text-center text-muted"><small>kW</small></h4>
                </div>
            </div>
        </div>
        <div class="col-sm-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-text text-center"><small class="text-danger font-weight-bold">Opname</small></h5>
                    <h1 id="usage_now" class="text-center font-weight-bold text-secondary">
                        {{ $metrics['intake_now'] / 1000 }}
                    </h1>
                    <h4 class="text-center text-muted"><small>kW</small></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <canvas id="chartEnergyUse"></canvas>
                            <div class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="chartRangeSelector btn-now btn btn-outline-secondary" onclick="this.blur();">Nu</button>
                                    <button type="button" class="chartRangeSelector btn-hour btn btn-outline-secondary active" onclick="this.blur();">Uur</button>
                                    <button type="button" class="chartRangeSelector btn-day btn btn-outline-secondary" onclick="this.blur();">Dag</button>
                                    <button type="button" class="chartRangeSelector btn-week btn btn-outline-secondary" onclick="this.blur();">Week</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <canvas id="chartEnergySolar"></canvas>
                            <div class="text-center">
                                <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                    <button type="button" class="chartRangeSelector btn-now btn btn-outline-secondary" onclick="this.blur();">Nu</button>
                                    <button type="button" class="chartRangeSelector btn-hour btn btn-outline-secondary active" onclick="this.blur();">Uur</button>
                                    <button type="button" class="chartRangeSelector btn-day btn btn-outline-secondary" onclick="this.blur();">Dag</button>
                                    <button type="button" class="chartRangeSelector btn-week btn btn-outline-secondary" onclick="this.blur();">Week</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <canvas id="chartEnergyRedelivery"></canvas>
                            <div class="text-center">
                                <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                    <button type="button" class="chartRangeSelector btn-now btn btn-outline-secondary" onclick="this.blur();">Nu</button>
                                    <button type="button" class="chartRangeSelector btn-hour btn btn-outline-secondary active" onclick="this.blur();">Uur</button>
                                    <button type="button" class="chartRangeSelector btn-day btn btn-outline-secondary" onclick="this.blur();">Dag</button>
                                    <button type="button" class="chartRangeSelector btn-week btn btn-outline-secondary" onclick="this.blur();">Week</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <canvas id="chartEnergyIntake"></canvas>
                            <div class="text-center">
                                <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                    <button type="button" class="chartRangeSelector btn-now btn btn-outline-secondary" onclick="this.blur();">Nu</button>
                                    <button type="button" class="chartRangeSelector btn-hour btn btn-outline-secondary active" onclick="this.blur();">Uur</button>
                                    <button type="button" class="chartRangeSelector btn-day btn btn-outline-secondary" onclick="this.blur();">Dag</button>
                                    <button type="button" class="chartRangeSelector btn-week btn btn-outline-secondary" onclick="this.blur();">Week</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-4">

            <div class="card mb-4">
                <div class="card-body text-center">
                    <h5><small class="text-secondary font-weight-bold">Opname vandaag</small></h5>
                    <h1 class="text-secondary font-weight-bold">{{ $metrics['total_usage_now_today'] }}<h4><small class="text-muted">kW</small></h4></h1>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body text-center">
                    <h5><small class="text-secondary font-weight-bold">Levering vandaag</small></h5>
                    <h1 class="text-secondary font-weight-bold">{{ $metrics['total_redelivery_now_today'] }}<h4><small class="text-muted">kW</small></h4></h1>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body text-center">
                    <h5><small class="text-secondary font-weight-bold">Gas vandaag</small></h5>
                    <h1 class="text-secondary font-weight-bold">{{ $metrics['total_usage_gas_now_today'] }}<h4><small class="text-muted">M&sup3;</small></h4></h1>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="text-center text-secondary">
                        <h5><small class="font-weight-bold">Meterstanden</small></h5>
                    </div>
                    <table class="table">
                        <tr>
                            <th class="text-muted">
                                Stroomopname hoog
                            </th>
                            <td>
                                {{ $metrics['usage_total_high'] }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted">
                                Stroomopname laag
                            </th>
                            <td>
                                {{ $metrics['usage_total_low'] }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted">
                                Stroomlevering hoog
                            </th>
                            <td>
                                {{ $metrics['redelivery_total_high'] }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted">
                                Stroomlevering laag
                            </th>
                            <td>
                                {{ $metrics['redelivery_total_low'] }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted">
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
@endsection

@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <script src="{{ asset('js/home.js') }}"></script>
@endsection
