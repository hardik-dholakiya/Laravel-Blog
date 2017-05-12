@extends('layouts.app')
@section('title')
    Blog :: 404 Error
@endsection
@section('content')
    <div align="center" style="background-color: #FFFFFF">
        {{--@if($error_message)--}}
            <h2> Exception
            </h2>
            <h4>
                {{--{{$error_message}}--}}
            </h4>
        {{--@else--}}
            <img src="{{asset('image/404 error.jpg')}}"><br>
            <h3>Error file not found.!!!</h3>
        {{--@endif--}}
    </div>
@endsection