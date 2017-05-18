<?php
namespace App\Repository\Interfaces;

interface LikeRepositoryInterface
{

    public function getTotalLike($post_id,$user_id);
    public function getById($post_id,$user_id);
    public function getByPostId($post_id);
    public function likePost($like_data);
    public function unlikePost($like_data);
}