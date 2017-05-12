<?php
namespace App\Repository\Interfaces;

interface PostRepositoryInterface
{
    public function index();

    public function storePost($data);

    public function getById($post_id);

    public function getPostById($post_id);

    public function search($search_text);

    public function editPost($data, $image_path);

    public function destroy($post_id);

}