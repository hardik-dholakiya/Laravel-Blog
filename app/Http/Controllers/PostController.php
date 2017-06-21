<?php


namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Notifications\NewPostNotification;
use App\Repository\Interfaces\PostRepositoryInterface;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * @var PostRepositoryInterface
     */
    protected $postRepository;

    /**
     * PostController constructor.
     */
    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = $this->postRepository->index();
        return view('Post.index', ['post' => $post]);
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Post.createPost');
    }

    public function store(PostRequest $postRequest)
    {
        $update = $postRequest->all();
        $path = 'image/';
        $user = Auth::user();
        if (isset($update['image'])) {
            $image_name = $update['image']->getClientOriginalName();
            $image_path = $postRequest->file('image')->move($path, $image_name);
        } else {
            $image_path = "";
        }

        $data = $postRequest->except('_token', 'image', 'submit_post', 'notify');
        $data['image_path'] = $image_path;
        $data['user_id'] = Auth::user()->id;
        $post = $this->postRepository->storePost($data);
        if (isset($update['notify'])== true) {
            $msg = 'You Create now post.';
            $user->notify(new NewPostNotification($post, $msg));
//        Notification::send($user, new NewPostNotification($post));
            }
        if (!empty($post)) {
            return redirect()->route('home')->withErrors(['message' => ' Post is successfully inserted.']);
        } else {
            return redirect()->back()->withErrors(['message' => ' Post is Not insert successfully.']);
        }
    }

    /**
     * Display post for edit post detail.
     */
    public function show($post_id)
    {
        $post = $this->postRepository->getById($post_id);
        return view('Post.editPostForm')->with("post", $post);
    }


    public function showPost($post_id)
    {
        $post = $this->postRepository->getPostById($post_id);
        return view('Post.showPost')->with("post", $post);
    }

    /**
     * search post by post title.
     */
    public function search(Request $request)
    {
        $search_text = $request->input('search_text');
        $search_post = $this->postRepository->search($search_text);
        return view('Post.search', ['search_post' => $search_post, 'search_text' => $search_text]);
    }

    /**
     * Update selected post.
     */
    public function update(PostRequest $post_request)
    {
        $path = 'image/';
        $update = $post_request->all();
        if (isset($update['new_image'])) {
            $image_name = $update['new_image']->getClientOriginalName();
            $image_path = $post_request->file('new_image')->move($path, $image_name);
        } else {
            if (isset($update['old_image']))
                $image_path = $update['old_image'];
            else
                $image_path = "";
        }

        $result = $this->postRepository->editPost($update, $image_path);
        if ($result > 0) {
            return redirect()->route('home')->withErrors(['message' => ' Post is successfully update']);
        } else {
            return redirect()->back()->withErrors(['message' => ' Post is not update successfully']);
        }
    }

    /**
     * Remove post.
     **/
    public function destroy($post_id)
    {
        $delete_post = $this->postRepository->destroy($post_id);
        if ($delete_post === true) {
            return redirect()->route('home')->withErrors(['message' => ' Post is successfully delete']);
        } else {
            return redirect()->back()->withErrors(['message' => ' Post is Not delete successfully']);
        }
    }
}
