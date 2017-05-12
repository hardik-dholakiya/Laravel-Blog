<?php
namespace App\Repository;

use App\Repository\Interfaces\UserRepositoryInterface;
use App\User;

class UserRepository implements UserRepositoryInterface
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function updatePassword($email,$new_password)
    {
        $result = User::where('email', '=', $email)
            ->update(['password' => $new_password]);
        return $result;
    }

    public function upProfile($data)
    {
        $result = User::where('id', $data['user_id'])
            ->update([
                'name' => $data['name'],
                'image' => $data['image'],
                'role' => $data['role']
            ]);
        return $result;
    }

    public function getUserById($user_id)
    {
        $user_detail=User::where('id',$user_id)->first();
        return$user_detail;
    }


}