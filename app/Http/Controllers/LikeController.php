<?php

namespace App\Http\Controllers;

use App\Repository\Interfaces\LikeRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    protected $likeRepository;
    public function __construct(LikeRepositoryInterface $likeRepository)
    {
        $this->likeRepository=$likeRepository;
    }

    public function storelike(Request $request)
    {
        $data = $request->only('post_id');
        $data['user_id'] = Auth::user()->id;
        $liked_total = $this->likeRepository->getTotalLike($data['post_id'],$data['user_id']);
        if ($liked_total == 0) {
            $result = $this->likeRepository->likePost($data);
            if (!empty($result)) {
                return redirect()->back()->withErrors(['message' => ' Post is successfully Liked']);
            } else {
                return redirect()->back()->withErrors(['message' => ' Post is not successfully like']);
            }

        } else {
            $like_id = $this->likeRepository->getById($data['post_id'],$data['user_id']);
            $result = $this->likeRepository->unlikePost($like_id['id']);
            if (!empty($result)) {
                return redirect()->back()->withErrors(['message' => ' Post is successfully Unlike']);
            } else {
                return redirect()->back()->withErrors(['message' => ' Post is not successfully Unlike']);
            }

        }
    }

    public function getByPostId(Request $request)
    {
        $data = $request->all();
        $post_id = $data['post_id'];
        $result = $this->likeRepository->getByPostId($post_id);
        foreach ($result as $key => $value) {
            $data[] = $value['user']['name'];
        }
        unset($data['post_id']);
        echo json_encode($data);
    }
}
