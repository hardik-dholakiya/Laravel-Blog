@extends('layouts.app')
@section('title')
    Blog::Change Password
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Change Password</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                        @if ($errors->has('message'))
                            <div class="alert alert-danger alert-dismissable fade in">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Error ! </strong> {{ $errors->first('message')}}.
                            </div>
                        @endif
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('updatePassword') }}"   onsubmit="return confirm('Do you really want to change password?');" >
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('oldPassword') ? ' has-error' : '' }}">
                            <label for="" class="col-md-4 control-label">Old Password</label>

                            <div class="col-md-6">
                                <input id="oldPassword" type="password" class="form-control" name="oldPassword" autofocus>

                                @if ($errors->has('oldPassword'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('oldPassword') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('newPassword') ? ' has-error' : '' }}">
                            <label for="newPassword" class="col-md-4 control-label"> New Password</label>

                            <div class="col-md-6">
                                <input id="newPassword" type="password" class="form-control" name="newPassword">

                                @if ($errors->has('newPassword'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('newPassword') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="confirm-password" class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input id="confirm-password" type="password" class="form-control" name="confirm-password">

                                @if ($errors->has('confirm-password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('confirm-password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Change Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
