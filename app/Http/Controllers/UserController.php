<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Repository\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    protected $userRepository;

    function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository=$userRepository;
    }

    public function changePassword(UserRequest $userRequest)
    {
        try {
            $user = Auth::user();
            $data = $userRequest->all();
            $old_password = $data['oldPassword'];
            $new_password = $data['newPassword'];
            $new_password = bcrypt($new_password);
            $email = Auth::user()->email;
            $password = Auth::user()->password;


            if ($password == Hash::check($old_password, $password)) {
                $result = $this->userRepository->updatePassword($email,$new_password);
            } else
                $result = null;
            if ($result > 0) {
                Mail::send('emails.changePassword', ['user' => $user, 'password' => $data['newPassword']], function ($m) use ($user) {
                    $m->to($user->email, $user->name)->subject('Change Password.');
                });
                return redirect()->route('home')->withErrors(['message' => 'Your password is successfully change.']);
            } else {
                return redirect()->back()->withErrors(['message' => ' Enter valid old Password .']);
            }
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }
    public function editProfile(Request $request)
    {
        $user_id=Auth::user()->id;
        $data=$request->all();

        $path = 'image/';
        if (isset($data['image'])) {
            $image_name = $data['image']->getClientOriginalName();
            $image_path = $request->file('image')->move($path, $image_name);
        } else {
            if (isset($data['old_image']))
                $image_path = $data['old_image'];
            else
                $image_path = "";
        }
        $user['image']=$image_path;
        $user['user_id']=$user_id;
        $user['name']=$data['name'];
        $user['role']= $data['userRole'];
        $result=$this->userRepository->upProfile($user);
        if ($result > 0) {
            return redirect()->route('home')->withErrors(['message' => 'Your Profile is successfully update']);
        } else {
            return redirect()->back()->withErrors(['message' => ' Your Profile is not update successfully']);
        }

    }

    public function showProfile($user_id)
    {
        $user_detail=$this->userRepository->getUserById($user_id);
        return view('auth.userProfile',['user_detail'=>$user_detail]);
    }
}
