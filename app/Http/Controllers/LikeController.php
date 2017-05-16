<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function storelike(Request $request)
    {
        $data = $request->only('post_id');
        $data['user_id'] = Auth::user()->id;
        $liked_total = Like::where('post_id', $data['post_id'])->where('user_id', $data['user_id'])->count();
        if ($liked_total == 0) {
            $result = Like::create($data);
            if (!empty($result)) {
                return redirect()->route('home')->withErrors(['message' => ' Post is successfully Liked']);
            } else {
                return redirect()->back()->withErrors(['message' => ' Post is not successfully like']);
            }

        } else {
            $liked = Like::where('post_id', $data['post_id'])->where('user_id', $data['user_id'])->first();
            $result = Like::where('id', $liked['id'])->delete();
            if (!empty($result)) {
                return redirect()->route('home')->withErrors(['message' => ' Post is successfully Unlike']);
            } else {
                return redirect()->back()->withErrors(['message' => ' Post is not successfully Unlike']);
            }

        }
    }

    public function getByPostId(Request $request)
    {
        $data = $request->all();
        $post_id = $data['post_id'];
        $result = Like::with('user')->where('post_id', $post_id)->get();

        foreach ($result as $key => $value) {
            $data[] = $value['user']['name'];
        }
        unset($data['post_id']);
        echo json_encode($data);
    }
}
