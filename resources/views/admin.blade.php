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
                                    ID
                                </th>
                                <th>
                                    @lang('defaultpage.name')
                                </th>
                                <th>
                                    Email
                                </th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                                <tr id="{{$user->id}}" class="user-acounts">
                                    <td>
                                        <p>{{$user->id}}</p>
                                    </td>
                                    <td>
                                        <p id="user-name-{{$user->id}}">{{$user->name}}</p>
                                    </td>
                                    <td>
                                        <p id="user-email-{{$user->id}}">{{$user->email}}</p>
                                    </td>
                                    <td id="edit-user-button-{{$user->id}}">
                                        <button class="btn btn-sm btn-default edit-user" onclick="this.blur();">
                                            <span class="glyphicon glyphicon-pencil"></span>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-default delete-user" onclick="this.blur();">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </button>
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
    <script src="{{ asset('js/manage.js') }}"></script>
@endsection
