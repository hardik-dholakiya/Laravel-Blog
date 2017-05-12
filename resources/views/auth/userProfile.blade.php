@extends('layouts.app')
@section('title')
    Blog :: User Profile
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading well-sm" align="center">
                        <h3>
                            User Profile
                        </h3>
                    </div>
                    <div class="panel-body">
                        <table   width="50%" class="table table-condensed">
                            <tr align="center">
                                <td>Name :- </td>
                                <td>{{ $user_detail->name}}</td>
                            </tr>
                            <tr align="center">
                                <td>Email id :- </td>
                                <td>{{ $user_detail->email}}</td>
                            </tr>
                            <tr align="center">
                                <td >Image :- </td>
                                <td>
                                    <img src="{{asset($user_detail->image)}}" height="200px">
                                    </td>
                            </tr>
                            <tr align="center">
                                <td>User Type</td>
                                <td>
                                    @if($user_detail->role==1)
                                        Admin
                                    @else
                                        User
                                    @endif
                                </td>
                            </tr>

                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection