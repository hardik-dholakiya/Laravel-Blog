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

    <style>
        .funkycheckbox div {
            clear: both;
            overflow: hidden;
        }

        .funkycheckbox label {
            width: 100%;
            border-radius: 3px;
            border: 1px solid #D1D3D4;
            font-weight: normal;
            border-radius: 0px;
        }

        .funkycheckbox input[type="checkbox"]:empty {
            display: none;
        }

        .funkycheckbox input[type="checkbox"]:empty ~ label {
            position: relative;
            line-height: 2.5em;
            text-indent: 3.25em;
            margin-top: 2em;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .funkycheckbox input[type="checkbox"]:empty ~ label:before {
            position: absolute;
            display: block;
            top: 0;
            bottom: 0;
            left: 0;
            content: '';
            width: 2.5em;
            background: #D1D3D4;
            border-radius: 0px;
        }

        .funkycheckbox input[type="checkbox"]:hover:not(:checked) ~ label {
            color: #888;
        }

        .funkycheckbox input[type="checkbox"]:hover:not(:checked) ~ label:before {
            content: '\2714';
            text-indent: .9em;
            color: #C2C2C2;
        }

        .funkycheckbox input[type="checkbox"]:checked ~ label {
            color: #777;
        }

        .funkycheckbox input[type="checkbox"]:checked ~ label:before {
            content: '\2714';
            text-indent: .9em;
            color: #333;
            background-color: #ccc;
        }

        .funkycheckbox input[type="checkbox"]:focus ~ label:before {
            box-shadow: 0 0 0 3px #999;
        }

        .funkycheckbox-default input[type="checkbox"]:checked ~ label:before {
            color: #333;
            background-color: #ccc;
        }

    </style>

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
                                    <img id="selectedImage" name="selectedImage" onerror="this.src='{{asset('image/no_image.png')}}'">
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
                                <div class="col-md-8 col-md-offset-3">
                                    {{--<input class="form-control" >--}}
                                    <div class="funkycheckbox">
                                        <div class="funkycheckbox-default">
                                            <input type="checkbox" id="publish" value="1" name="publish" checked/>
                                            <label for="publish">Post access all</label>
                                        </div>
                                        <div class="funkycheckbox-primary">
                                            <input type="checkbox" name="notify" id="notify" checked/>
                                            <label for="notify">Notify Post</label>
                                        </div>
                                    </div>

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
                $type=/[^.]+$/.exec(this.files[0]['name']);
                if ($type=='jpg'|| $type=='png') {
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
                }
                else {
                    alert("select only Image File...");
                    $('#image').removeAttr('value');

                }
            });
        });

    </script>
@endsection
