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
                            <form action="{{route('contact')}}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <label for="fname">First Name</label>
                                <input type="text" id="fname" name="firstname" class="contact-us"
                                       placeholder="Your name..">

                                <label for="lname">Last Name</label>
                                <input type="text" id="lname" class="contact-us" name="lastname"
                                       placeholder="Your last name..">

                                <label for="email">Email</label>
                                <input type="email" id="email" class="contact-us" name="email"
                                       placeholder="Your select email..">

                                <label for="subject">Subject</label>
                                <select id="subject" name="subject" class="contact-us">
                                    <option value="Inform">Inform</option>
                                    <option value="Feedback">Feedback</option>
                                </select>

                                <label for="file">File</label>
                                <input type="file" id="file" class="contact-us" name="file"
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