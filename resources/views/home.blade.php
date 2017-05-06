@extends('layouts.app')

@section('content')
<div class="container col-sm-12">
    <div class="col-lg-8 col-lg-offset-2 col-md-12">
        <div class="col-md-8">
            <div class="row">
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Heading graph
                        </div>
                        <div class="panel-body">
                            <canvas id="chartjsTest"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Heading metrics first
                        </div>
                        <div class="panel-body">
                            <canvas id="chartjsTest2"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Heading metrics second
                        </div>
                        <div class="panel-body">
                            <input type="button" class="button" value="Update" onclick="addPoint()">
                            <canvas id="chartjsTest3" height="400"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Heading side panel
                </div>
                <div class="panel-body">
                    Body side panel
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