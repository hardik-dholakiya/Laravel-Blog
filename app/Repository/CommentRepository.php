<?php
namespace App\Repository;

use App\Comment;
use App\Repository\Interfaces\CommentRepositoryInterface;

class CommentRepository implements CommentRepositoryInterface
{
    protected $comment;

    function __construct(Comment $comment)
    {
        $this->comment=$comment;
    }
    public function store($comment_data)
    {
        $result=$this->comment->create($comment_data);
        return $result;
    }
}