@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white font-weight-bold">
                        Energieverbruik

                        <div class="btn-group float-right" role="group" aria-label="...">
                            <button type="button" class="chartRangeSelector btn-day btn btn-sm btn-secondary active" onclick="this.blur();">Dagen</button>
                            <button type="button" class="chartRangeSelector btn-month btn btn-sm btn-secondary" onclick="this.blur();">Maanden</button>
                            <button type="button" class="chartRangeSelector btn-year btn btn-sm btn-secondary" onclick="this.blur();">Jaren</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="chartEnergyUse"></canvas>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header bg-danger text-white font-weight-bold">
                        Gasverbruik

                        <div class="btn-group float-right" role="group" aria-label="...">
                            <button type="button" class="chartRangeSelector btn-day btn btn-sm btn-secondary active" onclick="this.blur();">Dagen</button>
                            <button type="button" class="chartRangeSelector btn-month btn btn-sm btn-secondary" onclick="this.blur();">Maanden</button>
                            <button type="button" class="chartRangeSelector btn-year btn btn-sm btn-secondary" onclick="this.blur();">Jaren</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="chartGasUse"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white font-weight-bold">
                        Electricity sidebar
                    </div>
                    <div class="card-body">
                        Not yet implemented
                        <canvas id="gas-one" height=150></canvas>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white font-weight-bold">
                        Gas sidebar
                    </div>
                    <div class="card-body">
                        Not yet implemented
                        <canvas id="gas-one" height=150></canvas>
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
