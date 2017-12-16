@extends('layouts.app')

@section('content')
    <div class="container col-sm-12">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-12">
                <div class="col-sm-9 col-xs-12 col">
                    <div class="panel panel-info">

                        <div class="panel-heading">
                            <p class="panel-title pull-left">Energieverbruik</p>

                            <div class="btn-group pull-right" role="group" aria-label="...">
                                <button type="button" class="chartRangeSelector btn-day btn btn-sm btn-default active" onclick="this.blur();">Dagen</button>
                                <button type="button" class="chartRangeSelector btn-month btn btn-sm btn-default" onclick="this.blur();">Maanden</button>
                                <button type="button" class="chartRangeSelector btn-year btn btn-sm btn-default" onclick="this.blur();">Jaren</button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <canvas id="chartEnergyUse"></canvas>
                        </div>
                    </div>
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <p class="panel-title pull-left">Gasverbruik</p>

                            <div class="btn-group pull-right" role="group" aria-label="...">
                                <button type="button" class="chartRangeSelector btn-day btn btn-sm btn-default active" onclick="this.blur();">Dagen</button>
                                <button type="button" class="chartRangeSelector btn-month btn btn-sm btn-default" onclick="this.blur();">Maanden</button>
                                <button type="button" class="chartRangeSelector btn-year btn btn-sm btn-default" onclick="this.blur();">Jaren</button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <canvas id="chartGasUse"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-3 col-xs-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Electricity sidebar
                        </div>
                        <div class="panel-body">
                            Not yet implemented
                            <canvas id="gas-one" height=150></canvas>
                        </div>
                    </div>
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Gas sidebar
                        </div>
                        <div class="panel-body">
                            Not yet implemented
                            <canvas id="gas-one" height=150></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script src="{{ asset('js/history.js') }}"></script>
@endsection
