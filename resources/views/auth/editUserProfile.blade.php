<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
@extends('layouts.app')
@section('title')
    Blog::Edit User Profile
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Register</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST"
                              action="{{ route('edit-User-profile') }}"
                              enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name"
                                           value="{{ Auth::user()->name}}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="image" class="col-md-4 control-label">selected Image</label>
                                <div class="col-md-6">
                                    <img id="selectedImage" src="{{asset(Auth::user()->image)}}"
                                         onerror="this.src='{{asset('image/no-image-icon.jpg')}}'" height="250">
                                </div>
                            </div>
                            <div class="col-md-9 col-md-offset-4" style="margin-bottom: 10px">
                                <input type="button" id="removeImage" value="Remove image">
                            </div>


                            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                <label for="image" class="col-md-4 control-label">Image</label>

                                <div class="col-md-6">
                                    <input id="image" type="file" class="form-control" name="image" autofocus>
                                    <input type="hidden" id="old_image" name="old_image"
                                           value="{{Auth::user()->image}}">
                                    @if ($errors->has('image'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('userRole') ? ' has-error' : '' }}">
                                <label for="userRole" class="col-md-4 control-label">select user Role</label>

                                <div class="col-md-6">
                                    <select id="userRole" class="form-control" name="userRole"
                                            value="{{ old('userRole') }}" autofocus>
                                        <option value="0" {{Auth::user()->role==0?'selected':''}}>User</option>
                                        <option value="1" {{Auth::user()->role==1?'selected':''}}>Admin</option>
                                    </select>

                                    @if ($errors->has('userRole'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('userRole') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Update
                                    </button>
                                    <button type="reset" class="btn btn-primary">
                                        Reset
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
@section('body-include')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#image').change(function () {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#selectedImage')
                            .attr({
                                    'src': e.target.result,
                                    'width': '250px',
                                    'height': '250px'
                                }
                            )
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });

            $('#removeImage').click(function () {
                $('#selectedImage')
                    .attr('src', 'image/no-image-icon.jpg');
                $('#old_image').attr('value', '');
                $('#image').attr('value', '');
            });
        });

    </script>
@endsection