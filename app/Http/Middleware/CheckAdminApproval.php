<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdminApproval
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->admin_approval == 0) {
            Auth::logout();
            return redirect('/login')->withMessage('Account Inactive! Wait for admin approval');
        }
        return $next($request);
    }
}
