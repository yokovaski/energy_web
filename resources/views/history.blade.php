@extends('layouts.app')

@section('content')
    <div class="container col-sm-12">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        History
                    </div>
                    <div class="panel-body">
                        Not yet implemented
                        <canvas id="chartjsTest" height=150></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="{{ asset('js/test.js') }}"></script>
@endsection
