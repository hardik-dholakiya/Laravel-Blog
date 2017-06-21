@extends('layouts.app')
@section('title')
    Contact Us
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <link href="{{ asset('css/contact-us.css') }}" rel="stylesheet">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Contact Us</div>
                    <div class="panel-body">

                        <div class="contact-us-container ">
                            <form action="{{route('contact')}}" method="post" enctype="multipart/form-data"
                                  name="myForm" id="myForm">
                                {{ csrf_field() }}
                                <label for="fname">Name</label>
                                <input type="text" id="name" name="name" class="contact-us"
                                       placeholder="Your name..">

                                <label for="mobileNo">Mobile No</label>
                                <input type="text" id="mobileNo" class="contact-us" name="mobileno"
                                       placeholder="Your Mobile no..">

                                <label for="email">Email</label>
                                <input type="text" id="email" class="contact-us" name="email"
                                       placeholder="Your select email..">

                                <label for="subject">Subject</label>
                                <select id="subject" name="subject" class="contact-us">
                                    <option value="Inform">Inform</option>
                                    <option value="Feedback">Feedback</option>
                                </select>

                                <div class="col-lg-11" style="margin-left: -7px">
                                    <label for="file">File</label>

                                </div>
                                <div class="col-lg-1">
                                    <button name="addPet" class="btn" type="button" id="addPet">
                                        <span class="glyphicon glyphicon-plus"></span>
                                    </button>
                                </div>
                                <input type="file" class="contact-us file" name="file[]" id="file"
                                       placeholder="Your select file..">

                                <label for="message">Message</label>
                                <textarea id="message" class="contact-us" name="message" placeholder="Write something.."
                                          style="height:200px"></textarea>

                                <input type="submit" value="Submit" class="btn">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
@section('body-include')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js">
    </script>
    <script>
        $(document).ready(function () {
            $("#addPet").click(function () {
                var addfile = "<input type='file' class='contact-us' name='file[]' id='file'>";
                $("#file").after(addfile);
            });
        });
    </script>
@endsection