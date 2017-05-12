<?php
namespace App\Repository;

use App\Comment;
use App\Post;
use App\Repository\Interfaces\PostRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class PostRepository implements PostRepositoryInterface
{
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function index()
    {
        $user = Auth::user();
        if ($user->role == 1)
            $post = Post::with(array('user','likes','comments', 'comments.user', 'comments.reply', 'comments.reply.user'))->orderBy('title')->paginate(5);
        else
            $post = Post::with(array('user','likes','comments', 'comments.user', 'comments.reply', 'comments.reply.user'))->where('user_id', $user->id)->OrWhere('publish', 1)->orderBy('title')->paginate(5);
//        dd($post);
        return $post;

    }

    public function getPostById($post_id)
    {
        $post = Post::with(array('comments', 'comments.user', 'comments.reply', 'comments.reply.user'))->where('post_id',$post_id)->paginate(5);
        return $post;
    }


    public function storePost($data)
    {
        return $this->post->create($data);
    }

    public function getById($post_id)
    {
        $post = Post::where('post_id', $post_id)->first();
        return $post;
    }

    function editPost($data, $image_path)
    {
        $post_id = $data['post_id'];
        $publish = isset($data['publish']) ? 1 : 0;
        $result = Post::where('post_id', $post_id)
            ->update([
                'title' => $data['title'],
                'description' => $data['description'],
                'image_path' => $image_path,
                'publish' => $publish
            ]);
        return $result;

    }

    public function search($search_text)
    {
        $search_post = Post::with(['comments', 'comments.reply'])->where('title', 'like', "%$search_text%")->get();
        return $search_post;
    }

    public function destroy($post_id)
    {
        $delete_post = Post::where('post_id', $post_id)->delete();
        $delete_comment = Comment::where('post_id', $post_id)->delete();
        if ($delete_post > 0 || $delete_comment > 0) {
            return true;
        } else {
            return false;
        }
    }
}