<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Contracts\UserContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Creating instance of UserContract Model
     * @param \App\Contracts\UserContract $user
     * @return none
     */
    public function __construct(UserContract $user)
    {
        $this->user = $user;
    }
    //------------ END OF CONSTRUCTOR -----------//

    /**
     * Users page role wise data fetch
     */
    public function users()
    {
        if(Auth::user()) {
            $user_id = Auth::user()->id;
            $user_details = $this->user->userDetails($user_id);
            return view('users')->with('user_details', $user_details);
            
        } else {
            return redirect('/login');
        }
    }
    //------------ END OF FUNCTION --------------//

    /**
     * Get active users
     * @param none
     * @return \Illuminate\Http\JsonResponse
     */
    public function activeUsers()
    {
        try {
            $active_users = $this->user->activeUsers();
            return response()->json(
                [
                    'data' => $active_users,
                    'message' => 'List of all active users',
                    'status' => true,
                    'hasError' => 0
                ],
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    'data' => [],
                    'message' => $e->getMessage(),
                    'status' => false,
                    'hasError' => 1
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }   
    //------------ END OF FUNCTION --------------//

    /**
     * Get inactive users
     * @param none
     * @return \Illuminate\Http\JsonResponse
     */
    public function inactiveUsers()
    {
        try {
            $inactive_users = $this->user->inactiveUsers();
            return response()->json(
                [
                    'data' => $inactive_users,
                    'message' => 'List of all inactive users',
                    'status' => true,
                    'hasError' => 0
                ],
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    'data' => [],
                    'message' => $e->getMessage(),
                    'status' => false,
                    'hasError' => 1
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }   
    //------------ END OF FUNCTION --------------//

    /**
     * Approve or Disapprove User
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function approveOrDisApproveUser(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required',
                'admin_approval' => 'required|in:0,1'
            ]);
            $this->user->approveOrDisApproveUser($request->admin_approval, $request->user_id);
            $message = '';
            if ($request->admin_approval == '1') {
                $message = 'User profile approved';
            } else if($request->admin_approval == '0') {
                $message = 'User profile disapproved';
            }
            return response()->json(
                [
                    'data' => [],
                    'message' => $message,
                    'status' => 1,
                    'hasError' => 0
                ],
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            if ($e instanceof ValidationException) {
                return response()->json(
                    [
                        'data' => $e->errors(),
                        'message' => $e->getMessage(),
                        'status' => 0,
                        'hasError' => 1
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }
            return response()->json(
                [
                    'data' => [],
                    'message' => $e->getMessage(),
                    'status' => 0,
                    'hasError' => 1
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
