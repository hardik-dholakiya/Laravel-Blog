<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Repository\Interfaces\CommentRepositoryInterface;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $commentRepository;

    function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository=$commentRepository;
    }

    public function store(CommentRequest $request)
    {
        $data=$request->except('_token','comment_submit');
        $data['is_comment']=1;
        $result = $this->commentRepository->store($data);
        if (!empty($result)) {
            return redirect()->route('home')->withErrors(['message' => 'Comment is successfully Posted.']);
        } else {
            return redirect()->back()->withErrors(['message' => 'Comment is not successfully Posted.']);
        }
    }

    public function storeReply(Request $request)
    {
        $data=$request->except('_token','submit_reply','reply_text','comment_id');
        $data['is_comment']=0;
        $data['comment_text']=$request->input('reply_text');
        $data['reply_to_comment']=$request->input('comment_id');
        $result= $this->commentRepository->store($data);
        if (!empty($result)) {
            return redirect()->route('home')->withErrors(['message' => 'Reply is successfully Posted.']);
        } else {
            return redirect()->back()->withErrors(['message' => 'Reply is not successfully Posted.']);
        }
    }

}
