<?php

namespace App\Repositories;

use App\Contracts\UserContract;
use App\User;

class UserRepository implements UserContract
{
    // Local variable
    protected $user;

    /**
     * Creating instance of User Model
     * @param \App\User $user
     * @return none
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    //----------- END OF CONSTRUCTOR ------------//

    /**
     * Return all active users
     * @param none
     * @return result
     */
    public function activeUsers()
    {  
        return $this->user->role('subscriber')->where('admin_approval', '1')->get();
    }
    //----------- END OF FUNCTION ------------//

    /**
     * Return all inactive users
     * @param none
     */
    public function inactiveUsers()
    {  
        return $this->user->role('subscriber')->where('admin_approval', '0')->get();
    }
    //----------- END OF FUNCTION ------------//

    /**
     * Return user details
     * @param [user_id]
     * @return result
     */
    public function userDetails($user_id)
    {
        return $this->user->findOrFail($user_id);
    }
    //----------- END OF FUNCTION ------------//

    /**
     * Approve or Disapprove User
     * @param [approve, user_id]
     * @return result
     */
    public function approveOrDisApproveUser($approve, $user_id)
    {
        return $this->user->where('id', $user_id)->update([
            'admin_approval' => $approve
        ]);
    }
    //----------- END OF FUNCTION ------------//
}