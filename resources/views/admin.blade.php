@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white font-weight-bold">
                        Users
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover">
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
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white font-weight-bold">
                        Raspberry Pi's
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover">
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
@endsection
