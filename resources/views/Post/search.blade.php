<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
@extends('layouts.app')
@section('title')
    Blog :: Search post
@endsection
@section('content')
    <div class="container" style="width: 85%">
        <div class="panel panel-default">
            <div class="panel-body">
                @if(count($search_post)>0)
                    <div class="alert alert-success alert-dismissable fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>{{ucwords($search_text)}} ! </strong> search Post found.
                    </div>
                    @foreach($search_post as $post_id=>$post_detail)
                        <div>
                            <div class="well" align="center" style="padding: 5px;font-size: 24px;">
                                <b>
                                    {!!  ucfirst($post_detail['title'])!!}
                                </b>
                            </div>
                            @if(Auth::user()->id==$post_detail['user_id'] || Auth::user()->role==1 )
                                <div align="right">
                                    <a href="{{ url('/show',$post_detail['post_id'])}}" class="btn btn-info"
                                       title="Edit">
                                        <span class="glyphicon glyphicon-edit"></span>
                                        Edit
                                    </a>
                                    <a href="{{ url('/deletePost',$post_detail['post_id'])}}" class="btn btn-info"
                                       title="Delete">
                                        <span class="glyphicon glyphicon-trash"></span>
                                        Delete
                                    </a>
                                </div>
                            @endif
                            <div class="row">
                                @if($post_detail['image_path']!=null)
                                    <div class="col-md-3">
                                        <img src="{{$post_detail['image_path']}}"
                                             onerror="this.src='{{asset('image/no-image-icon.jpg')}}'" width="250px"
                                             height="200px">
                                    </div>
                                    <div class="col-md-8">
                                        {!! ucfirst(limit_text($post_detail['description'],50)) !!}
                                        <br/>
                                        <a href="{{ url('/showPost',$post_detail['post_id'])}}">
                                            See more...
                                        </a>
                                    </div>
                                @else
                                    <div class="col-lg-offset-1">
                                        {!! ucfirst(limit_text($post_detail['description'],50)) !!}
                                        <br/>
                                        <a href="{{ url('/showPost',$post_detail['post_id'])}}">
                                            See more...
                                        </a>
                                    </div>
                                @endif

                            </div>
                            <div class="row">
                                <div class="col-md-1 col-md-offset-3">
                                    <a href="javascript:void(0)" class=" btn btn-default like" id="like" name="like"
                                       data-post-id="{{$post_detail['post_id']}}" data-toggle="tooltip"
                                       data-placement="bottom">
                                        <b>
                                            {{count($post_detail['Likes'])}} |
                                        </b>
                                        <img src="{{asset('image/like-flat.png')}}" height="19px">
                                    </a>
                                    <form id="like-form-{{$post_detail['post_id']}}" class="like-form"
                                          action="{{ route('like') }}" method="POST"
                                          style="display: none;">
                                        <input type="hidden" name="post_id" value="{{$post_detail['post_id']}}">
                                        {{ csrf_field() }}
                                    </form>
                                </div>

                                <div class="col-md-5 ">
                                    <a class="btn btn-default" href="javascript:void(0)" data-toggle="modal"
                                       data-target="#CommentModal{{$post_detail['post_id']}}" title="Comment">
                                        <img src="{{asset('image/comment.png')}}" height="20px">
                                    </a>

                                    <!-- Modal -->
                                    <div class="modal fade" id="CommentModal{{$post_detail['post_id']}}"
                                         role="dialog">
                                        <div class="modal-dialog modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close"
                                                        data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Comment</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form name="comment_form" action="{{route('storeComment')}}"
                                                      method="post">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="post_id"
                                                           value="{{$post_detail['post_id']}}">
                                                    <input type="hidden" name="user_id"
                                                           value="{{Auth::user()->id}}">
                                                    <textarea name="comment_text" rows="5" cols="85"
                                                              required></textarea>
                                                    <hr>
                                                    <input class="btn btn-info" type="submit"
                                                           name="comment_submit"
                                                           value="Post Comment">
                                                    <button type="button" class="btn btn-info"
                                                            data-dismiss="modal">
                                                        Close
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div> <!--End Modal-->

                                </div>
                                <div class="col-md-2">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                    {{$post_detail['created_at']->format('d/m/y  h:i:s')}}
                                </div>
                            </div>
                            <div style="margin: 10px 0px 10px 50px;">
                                @foreach($post_detail['comments'] as $comment_id=>$comment_detail)
                                    @if($comment_detail['is_comment']==1)
                                        <img src="{{asset($comment_detail->user->image)}}"
                                             onerror="this.src='{{asset('image/user-icon.png')}}'"
                                             height="30px" class="img-circle" title="{{$comment_detail->user->name}}">

                                        {{$comment_detail->user['name']." : "}}
                                        {{$comment_detail["comment_text"]}}
                                        <a href="javascript:void(0)" class="comment_reply"
                                           id="click{{$comment_detail["comment_id"]}}"
                                           data-comment-id="{{$comment_detail["comment_id"]}}"
                                           data-post-id="{{$post_detail['post_id']}}">
                                            Reply
                                        </a>
                                        <br/>

                                    @endif
                                    @foreach($comment_detail['reply'] as $reply=>$reply_detail)
                                        <div style="margin: 5px 0px 5px 60px;">
                                            <img src="{{asset($reply_detail->user->image)}}"
                                                 onerror="this.src='{{asset('image/user-icon.png')}}'"
                                                 height="30px" class="img-circle" title="{{$reply_detail->user->name}}">
                                            {{ $reply_detail->user->name." : " }}
                                            {{ $reply_detail["comment_text"] }}
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                        <hr>
                    @endforeach
                   @else
                    <div align="center">
                        <h3>
                            <strong> '{{$search_text}}'</strong> post not found
                        </h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script>
        $(document).on('click', '.comment_reply', function (e) {
            $('.comment_reply').not(this).popover('hide');
            $(this).popover(
                {

                    content: "<div><form action='{{route('storeReply')}}' method='post'>" + '{{ csrf_field() }}' +
                    "<textarea name='reply_text' required cols='38' rows='6'></textarea>" +
                    "<input type='hidden' readonly name='user_id' value='{{Auth::user()->id}}'>" +
                    "<input type='hidden' readonly name='post_id' value='" + $(this).data('post-id') + "'>" +
                    "<input type='hidden' readonly name='comment_id' value='" + $(this).data('comment-id') + "'>" +
                    "<hr>" +
                    "<button class='btn btn-default' type='submit' name='submit_reply'> Save Reply</button> &nbsp;&nbsp;" +
                    "<input type='button' onclick='$(this).parent().parent().parent().parent().hide();' value='close' class='btn btn-default'></button>" +
                    "</form></div>",
                    title: "<h4>Reply</h4>",
                    html: true,
                    placement: "right"
                });
        });
    </script>
@endsection
@section('head-include')
    <script type="text/javascript">
        $(document).ready(function () {
            $.ajaxSetup(
                {
                    headers: {
                        'X-CSRF-Token': $('input[name="_token"]').val()
                    }
                });
            $(document).on('mouseenter', '.like', function () {
                var $this = $(this);
                var post_id = $(this).data('post-id');
                var name;
                $.ajax({
                    type: 'POST',
                    url: '{{route("getLike")}}',
                    data: {
                        post_id: post_id
                    },
                    dataType: "json",
                    success: function (data) {
                        if (Object.keys(data).length > 0) {
                            name = Object.values(data);
                        }
                        else
                            name = "Any one no Like.";
                        $this.attr('title', name)
                            .tooltip('fixTitle')
                            .tooltip('show');
                    },
                    error: function (data) {
                        console.log("error");
                    }
                });
                return false;
            });
        });


        $(document).on('click', '.like', function (e) {
            var post_id = $(this).data('post-id');
            $("#like-form-" + post_id).submit();
        });
    </script>
@endsection
<?php
function limit_text($text, $limit)
{
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos = array_keys($words);
        $text = substr($text, 0, $pos[$limit]) . '...';
    }
    return $text;
}
?>
