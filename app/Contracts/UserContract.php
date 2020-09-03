<?php

namespace App\Contracts;

interface UserContract
{
    // active users
    public function activeUsers();
    // inactive users
    public function inactiveUsers();
    // user details
    public function userDetails($user_id);
    // user approve or disapprove
    public function approveOrDisApproveUser($approve, $user_id);
}