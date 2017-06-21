@extends('layouts.app')

@section('content')
    <div class="container col-sm-12">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Users
                    </div>
                    <div class="panel-body">
                        <table class="table table-responsive table-striped">
                            <thead>
                            <tr>
                                <th>
                                    <p>ID</p>
                                </th>
                                <th>
                                    <p>@lang('defaultpage.name')</p>
                                </th>
                                <th>
                                    <p>Email</p>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <p>{{$user->id}}</p>
                                    </td>
                                    <td>
                                        <p>{{$user->name}}</p>
                                    </td>
                                    <td>
                                        <p>{{$user->email}}</p>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Raspberry Pi's
                    </div>
                    <div class="panel-body">
                        <table class="table table-responsive table-striped">
                            <thead>
                            <tr>
                                <th>
                                    <p>ID</p>
                                </th>
                                <th>
                                    <p>@lang('defaultpage.owner')</p>
                                </th>
                                <th>
                                    <p>@lang('defaultpage.ip-address')</p>
                                </th>
                                <th>
                                    <p>@lang('defaultpage.mac-address')</p>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($raspberryPis as $raspberryPi)
                                <tr>
                                    <td>
                                        <p>{{$raspberryPi->id}}</p>
                                    </td>
                                    <td>
                                        <p>{{$raspberryPi->user->name}}</p>
                                    </td>
                                    <td>
                                        <p>{{$raspberryPi->ip_address}}</p>
                                    </td>
                                    <td>
                                        <p>{{$raspberryPi->mac_address}}</p>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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
