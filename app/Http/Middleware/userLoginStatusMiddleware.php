<?php

namespace App\Http\Middleware;

use Closure;

use Auth;

use Illuminate\Support\Facades\Session;
class userLoginStatusMiddleware
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

        $response = $next($request);
     
        if(Auth::check() && Auth::user()->status != 1){
            Auth::logout();
             return redirect()->back()->with('errorlogin', 'YOUR ACCOUNT HAS BEEN DEACTIVATED PLEASE CONTACT CUSTOMER SUPPORT!'); 
             
        }

        return $response;
        
    }
}
