<?php
namespace App\Repository;

use App\Like;
use App\Repository\Interfaces\LikeRepositoryInterface;

class LikeRepository implements LikeRepositoryInterface
{
    protected $like;

    function __construct(Like $like)
    {
        $this->like=$like;
    }
    public function getByTotalLike($post_id,$user_id)
    {
        $no_of_like=Like::where('post_id', $post_id)->where('user_id', $user_id)->count();
        return $no_of_like;
    }

    public function likePost($like_data)
    {
        $result = Like::create($like_data);
        return $result;
    }
    public function unlikePost($like_id)
    {
        $result = Like::where('id', $like_id)->delete();
        return $result;
    }
    public function getById($post_id, $user_id)
    {
        $like_id = Like::where('post_id', $post_id)->where('user_id', $user_id)->first();
        return $like_id;
    }
    public function getByPostId($post_id)
    {
     $result=Like::with('user')->where('post_id', $post_id)->get();
     return $result;
    }

}