<?php
namespace App\Repository\Interfaces;

interface UserRepositoryInterface
{

    public function updatePassword($email,$new_password);

    public function upProfile($data);

    public function getUserById($user_id);
}