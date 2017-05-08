@extends('layouts.app')

@section('content')
<div class="container col-sm-12">
    <div class="col-lg-8 col-lg-offset-2 col-md-12">
        <div class="row">
            <div class="col-sm-4">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        Energieverbruik
                    </div>
                    <div class="panel-body">
                        <h4>
                            382 Wh
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        Energieopwekking
                    </div>
                    <div class="panel-body">
                        <h4>
                            874 Wh
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        Energielevering
                    </div>
                    <div class="panel-body">
                        <h4>
                            -508 Wh
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
                                <canvas id="chartjsTest" height=150></canvas>
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
                                <input type="button" class="button" value="Update" onclick="addPoint()">
                                <canvas id="chartjsTest3"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Energie gegevens
                    </div>
                    <div class="panel-body">
                        <table class="table table-responsive table-hover">
                            <tr>
                                <th>
                                    Meterstanden
                                </th>
                                <th></th>
                            </tr>
                            <tr>
                                <td>
                                    Stroomopname
                                </td>
                                <td>
                                    42845642
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Stroomlevering
                                </td>
                                <td>
                                    42845642
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Gas
                                </td>
                                <td>
                                    42845642
                                </td>
                            </tr>
                        </table>
                        <br>
                        <table class="table table-responsive table-hover">
                            <tr>
                                <th>
                                    Dag gemiddelde
                                </th>
                                <th></th>
                            </tr>
                            <tr>
                                <td>
                                    Stroomopname
                                </td>
                                <td>
                                    428
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Stroomlevering
                                </td>
                                <td>
                                    654
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Gas
                                </td>
                                <td>
                                    4
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script src="{{ asset('js/test.js') }}"></script>
@endsection