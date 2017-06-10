<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
@extends('layouts.app')
@section('title')
    Blog :: Home
@endsection
@section('content')
    <div class="container" style="width: 85%">
        <div class="panel panel-default">
            <div class="panel-body">
                @if ($errors->has('message'))
                    <div class="alert alert-success alert-dismissable fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Success ! </strong> {{ $errors->first('message')}}.
                    </div>
                @endif
                @foreach($post as $post_id=>$post_detail)
                    <div>
                        <div class="well" align="center" style="padding: 5px;font-size: 24px;">
                            <b>
                                {!!  ucfirst($post_detail['title'])!!}
                            </b>
                        </div>
                        @if(Auth::user()->id==$post_detail['user_id'] || Auth::user()->role==1 )
                            <div align="right">
                                <a href="{{ url('/show',$post_detail['post_id'])}}" class="btn btn-info"
                                   title="Edit Post">
                                    <span class="glyphicon glyphicon-edit"></span>
                                    Edit
                                </a>
                                <a href="{{ url('/deletePost',$post_detail['post_id'])}}" class="btn btn-info"
                                   onclick="return confirm('Do you really want to delete post?');"
                                   title="Delete Post">
                                    <span class="glyphicon glyphicon-trash"></span>
                                    Delete
                                </a>
                            </div>
                        @endif
                        <div class="row">
                            @if($post_detail['image_path']!=null)
                                <div class="col-md-3">
                                    <img src="{{asset($post_detail['image_path'])}}"
                                         onerror="this.src='{{asset('image/no-image-icon.jpg')}}'" width="250px"
                                         height="200px">
                                </div>
                                <div class="col-md-8 description">
                                    {!! ucfirst(limit_text($post_detail['description'],50)) !!}
                                    <br/>
                                    <a href="{{ url('/showPost',$post_detail['post_id'])}}"
                                       class="btn btn-default">
                                        See More...
                                    </a>
                                </div>
                            @else
                                <div class="col-lg-offset-1 description ">
                                    {!! ucfirst(limit_text($post_detail['description'],50)) !!}
                                    <br/>
                                    <a href="{{ url('/showPost',$post_detail['post_id'])}}">
                                        See more...
                                    </a>
                                </div>
                            @endif

                        </div>
                        <div class="row">
                            <div class="col-md-2 col-md-offset-3">
                                <span class="glyphicon glyphicon-user"></span>
                                <strong>
                                    Post by
                                    <a href="{{url('show-user-profile/'.$post_detail['user']->id)}}">
                                        {{$post_detail['user']->name}}
                                    </a>
                                </strong>
                            </div>
                            <div class="col-md-1">
                                <a href="javascript:void(0)" class="btn btn-default like" id="like" name="like"
                                   data-post-id="{{$post_detail['post_id']}}" data-toggle="tooltip"
                                   data-placement="bottom">
                                    <b>
                                        {{count($post_detail['Likes'])}} |
                                    </b>
                                    <img src="{{asset('image/like-flat.png')}}" height="20px">
                                </a>
                                <form id="like-form-{{$post_detail['post_id']}}" class="like-form"
                                      action="{{ route('like') }}" method="POST"
                                      style="display: none;">
                                    <input type="hidden" name="post_id" value="{{$post_detail['post_id']}}">
                                    {{ csrf_field() }}
                                </form>
                            </div>

                            <div class="col-md-4 comment-link">
                                <a class="btn btn-default" href="javascript:void(0)" data-toggle="modal"
                                   data-target="#CommentModal{{$post_detail['post_id']}}" title="Comment">
                                    <b>
                                        {{count($post_detail['Comments'])}} |
                                    </b>
                                    <img src="{{asset('image/comment.png')}}">
                                </a>

                            </div>
                            <div class="col-md-2">
                                <span class="glyphicon glyphicon-calendar"></span>
                                {{ time_ago($post_detail['created_at'])}}
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="CommentModal{{$post_detail['post_id']}}"
                             role="dialog">
                            <div class="modal-dialog modal-content" style=" width: 80%;">
                                <div class="modal-header">
                                    <button type="button" class="close"
                                            data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Comment</h4>
                                </div>
                                <div class="modal-body">

                                    <div style="margin: 10px 0px 10px 50px;">
                                        <ul class="comment-section">
                                            @foreach($post_detail['comments'] as $comment_id=>$comment_detail)
                                                @if($comment_detail['is_comment']==1)
                                                    {{--Comment--}}
                                                    <li class="comment user-comment">
                                                        <div class="info">
                                                            <a href="{{url('show-user-profile/'.$comment_detail->user->id)}}">{{$comment_detail->user['name']}}</a>
                                                            <span>{{time_ago($comment_detail['created_at'])}}</span>
                                                        </div>
                                                        <a class="avatar"
                                                           href="{{url('show-user-profile/'.$comment_detail->user->id)}}">
                                                            <img src="{{asset($comment_detail->user->image)}}"
                                                                 onerror="this.src='{{asset('image/user-icon.png')}}'"
                                                                 height="30px" title="{{$comment_detail->user->name}}"
                                                                 width="35"
                                                                 alt="Profile Avatar"/>
                                                        </a>
                                                        <p>{!! $comment_detail["comment_text"] !!}
                                                            <label class="reply-link">
                                                                <a href="javascript:void(0)"
                                                                   data-toggle="collapse"
                                                                   id="reply"
                                                                   data-target="#reply-{{$comment_detail["comment_id"]}}"
                                                                   class="btn btn-default btn-sm reply">
                                                                    <i class="fa fa-reply"></i> Reply
                                                                </a>
                                                            </label>
                                                        </p>
                                                        <div id="reply-{{$comment_detail["comment_id"]}}"
                                                             class="collapse container reply-block" align="center">
                                                            <div class="panel panel-info">
                                                                <div class="panel-heading">Reply</div>
                                                                <div class="panel-body">
                                                                    <form action='{{route('storeReply')}}'
                                                                          method='post'>
                                                                        {{ csrf_field() }}
                                                                        <textarea name='reply_text' required cols='90'
                                                                                  rows='5'></textarea>
                                                                        <input type='hidden' readonly name='user_id'
                                                                               value='{{Auth::user()->id}}'>
                                                                        <input type='hidden' readonly name='post_id'
                                                                               value='{{$post_detail['post_id']}}'>
                                                                        <input type='hidden' readonly name='comment_id'
                                                                               value='{{$comment_detail["comment_id"]}}'>
                                                                        <button class='btn btn-default' type='submit'
                                                                                style="margin-top: -35px;"
                                                                                name='submit_reply'> Save Reply
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    {{--end comment --}}
                                                @endif
                                                @foreach($comment_detail['reply'] as $reply=>$reply_detail)
                                                    <li class="comment user-comment" style="margin-left: 135px;">
                                                        <div class="info">
                                                            <a href="{{url('show-user-profile/'.$reply_detail->user->id)}}">{{ $reply_detail->user->name }}</a>
                                                            <span>{{time_ago($reply_detail['created_at'])}}</span>
                                                        </div>

                                                        <a class="avatar"
                                                           href="{{url('show-user-profile/'.$reply_detail->user->id)}}">
                                                            <img src="{{asset($reply_detail->user->image)}}"
                                                                 onerror="this.src='{{asset('image/user-icon.png')}}'"
                                                                 title="{{$reply_detail->user->name}}"
                                                                 width="35" alt="{{ $reply_detail->user->name }}"/>
                                                        </a>
                                                        <p style="background-color: #e2f8ff;">{{ $reply_detail["comment_text"] }}</p>
                                                    </li>
                                                @endforeach
                                            @endforeach
                                            <li class="write-new">
                                                <h4>Comment</h4>
                                                <form name="comment_form" action="{{route('storeComment')}}"
                                                      method="post">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="post_id"
                                                           value="{{$post_detail['post_id']}}">
                                                    <input type="hidden" name="user_id"
                                                           value="{{Auth::user()->id}}">
                                                    <textarea name="comment_text" rows="5" cols="85"
                                                              required placeholder="Write your comment here"></textarea>
                                                    <div>
                                                        <img src="{{asset(Auth::user()->image)}}" width="35"
                                                             alt="Profile of Bradley Jones" title="Bradley Jones"/>
                                                        <button name="comment_submit"
                                                                type="submit">Post Comment
                                                        </button>
                                                    </div>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div> <!--End Modal-->
                    </div>
                    <hr>
                @endforeach
                <div align="center">
                    <ul class="pager">
                        <li><a href="{{url('home?page=1')}}">
                                First</a>
                        </li>
                        <li><a href="{{$post->previousPageUrl()}}">Previous</a></li>
                        <li><a href="{{$post->nextPageUrl()}}">Next</a></li>
                        <li><a href="{{url('home?page='.$post->lastPage())}}">
                                Last</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
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
                        name = Object.values(data);
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
function time_ago($datetime, $full = false)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

?>
