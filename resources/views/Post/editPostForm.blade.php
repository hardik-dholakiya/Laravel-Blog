@extends('layouts.app')
@section('head-include')
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

    <!-- Redactor is here -->
    <link rel="stylesheet" href="../js/redactor/redactor.min.css"/>
    <script src="../js/redactor/redactor.min.js"></script>

    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $('.description').redactor({
                focus: true
            });
        });
    </script>
    <!-- end Redactor-->
@endsection

@section('title')
    Blog :: Edit Post Detail
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center"><h3>Edit Post</h3></div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('editPost') }}"
                              enctype="multipart/form-data">
                            {{ csrf_field() }}
                            @if ($errors->has('message'))
                                <div class="alert alert-danger">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Error!</strong> {{ $errors->first('message') }}.
                                </div>
                            @endif
                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="title" class="col-md-3 control-label">Post Title</label>
                                <div class="col-md-8">
                                    <input id="title" type="text" class="form-control" name="title"
                                           value="{{$post->title}}" autofocus>
                                    @if ($errors->has('title'))
                                        <div class="alert alert-danger" style=" margin-bottom: 1px;padding: 5px;">
                                            <a href="#" class="close" data-dismiss="alert"
                                               aria-label="close">&times;</a>
                                            <strong>Error!</strong> {{ $errors->first('title') }}.
                                        </div>
                                    @endif

                                </div>

                            </div>
                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}"><label
                                        for="description" class="col-md-3 control-label">Post Description</label>
                                <div class="col-md-8">
                                    <textarea id="description" rows="9" class="form-control description"
                                              name="description">{{$post->description}}</textarea>
                                    @if ($errors->has('description'))
                                        <div class="alert alert-danger" style=" margin-bottom: 1px;padding: 5px;">
                                            <a href="#" class="close" data-dismiss="alert"
                                               aria-label="close">&times;</a>
                                            <strong>Error ! </strong> {{ $errors->first('description') }}.
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @if($post->image_path != null)
                                <div class="form-group{{ $errors->has('image_path') ? ' has-error' : '' }}"><label
                                            for="image" class="col-md-3 control-label">Selected image :-</label>
                                    <div class="col-md-5">
                                        <img src="{{asset($post->image_path)}}" id="image" height="200px"
                                             width="300px"
                                             onerror="this.src='{{asset('image/no-image-icon.jpg')}}'">
                                        <input type="hidden" id="old_image" name="old_image"
                                               value="{{$post->image_path}}">
                                    </div>
                                    <div class="col-md-1">
                                        <input type="button" id="removeImage" style="margin-top: 350%;"
                                               value="Remove image">
                                    </div>
                                </div>
                            @endif

                            <div class="form-group{{ $errors->has('new_image') ? ' has-error' : '' }}"><label
                                        for="image" class="col-md-3 control-label">Select File </label>
                                <div class="col-md-8">
                                    <input id="new_image" type="file" class="form-control" name="new_image">
                                    @if ($errors->has('new_image'))
                                        <div class="alert alert-danger" style=" margin-bottom: 1px;padding: 5px;">
                                            <a href="#" class="close" data-dismiss="alert"
                                               aria-label="close">&times;</a>
                                            <strong>Error ! </strong> {{ $errors->first('new_image') }}.
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="publish" class="col-md-3 control-label">Post publish</label>
                                <div class="col-md-1">
                                    <input id="publish" value="1" type="checkbox" class="form-control"
                                           name="publish" {{ $post->publish==1?"checked":""}}>
                                </div>
                            </div>

                            <div class="form-group">
                                <input id="post_id" type="hidden" name="post_id"
                                       value="{{$post->post_id}}">
                                <div class="col-md-8 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary" name="update_post">
                                        Save post
                                    </button>
                                    <button type="reset" class="btn btn-primary" id="resetData">
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
    <script>
        $(document).ready(function () {
            $('#new_image').change(function () {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#image')
                            .attr('src', e.target.result)
                    };
                    reader.readAsDataURL(this.files[0]);
                }

            });
            $('#removeImage').click(function () {
                $('#image')
                    .attr('src', '{{asset('image/no-image-icon.jpg')}}');
                $('#old_image').attr('value', '');
                $('#new_image').attr('value', '');
            });

            $('#resetData').click(function () {
                var old_data = $('#old_image').val();
                $('#image')
                    .attr('src', '../' + old_data);
            });
        });

    </script>
@endsection