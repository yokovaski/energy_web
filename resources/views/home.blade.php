@extends('layouts.app')

@section('content')
<div class="container col-sm-12">
    <div class="col-sm-8 col-sm-offset-2 col-xs-12">
        <div class="col-md-8">
            <div class="row">
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Heading graph
                        </div>
                        <div class="panel-body">
                            Body graph
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Heading metrics first
                        </div>
                        <div class="panel-body">
                            Body metrics first
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Heading metrics second
                        </div>
                        <div class="panel-body">
                            Body metrics second
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

@endsection