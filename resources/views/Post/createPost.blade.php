@extends('layouts.app')
@section('head-include')
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>--}}
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

    <!-- Redactor is here -->
    <link rel="stylesheet" href="js/redactor/redactor.min.css"/>
    <script src="js/redactor/redactor.min.js"></script>


    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $('.description').redactor({
                focus: true
            });
        });
    </script>


@endsection
@section('title')
    Blog :: Create post
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center"><h3>Create Post</h3></div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('storesPost') }}"
                              enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="title" class="col-md-3 control-label">Post Title</label>
                                <div class="col-md-8">
                                    <input id="title" type="text" class="form-control" name="title"
                                           value="{{ old('title') }}" autofocus>
                                    @if ($errors->has('title'))
                                        <div class="alert alert-danger" style=" margin-bottom: 1px;padding: 5px;">
                                            <a href="#" class="close" data-dismiss="alert"
                                               aria-label="close">&times;</a>
                                            <strong>Error!</strong> {{ $errors->first('title') }}.
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description" class="col-md-3 control-label">Post Description</label>
                                <div class="col-md-8">
                                    <textarea id="description" class="form-control description"
                                              name="description">{{ old('description') }}</textarea>
                                    @if ($errors->has('description'))
                                        <div class="alert alert-danger" style=" margin-bottom: 1px;padding: 5px;">
                                            <a href="#" class="close" data-dismiss="alert"
                                               aria-label="close">&times;</a>
                                            <strong>Error!</strong> {{ $errors->first('description') }}.
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class=" col-lg-offset-3 col-md-8">
                                    <img id="selectedImage" name="selectedImage">
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                <label for="image" class="col-md-3 control-label">Select File </label>
                                <div class="col-md-8">
                                    <input id="image" type="file" class="form-control" name="image">
                                    @if ($errors->has('image'))
                                        <div class="alert alert-danger" style=" margin-bottom: 1px;padding: 5px;">
                                            <a href="#" class="close" data-dismiss="alert"
                                               aria-label="close">&times;</a>
                                            <strong>Error!</strong> {{ $errors->first('image') }}.
                                        </div>
                                    @endif

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="publish" class="col-md-3 control-label">Post publish</label>
                                <div class="col-md-1">
                                    <input id="publish" value="1" type="checkbox" class="form-control" name="publish">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary" name="submit_post">
                                        Create new post
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
                                    'width': '300px',
                                    'height': '200px'
                                }
                            )
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });

    </script>
@endsection
