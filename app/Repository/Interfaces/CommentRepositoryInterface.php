<?php
namespace App\Repository\Interfaces;

interface CommentRepositoryInterface
{
    public function store($comment_data);
}