<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            
            $user = Auth::user();
            switch(true) {
                 case $user->hasRole('teacher'):
                    return redirect('/teacher');
             case $user->hasRole('parent'):
                    return redirect('/parent');  
             case $user->hasRole('admission-officer'):
                return redirect('/admission-officer');    
             case $user->hasRole('demonstration-officer'):
                return redirect('/demonstration-officer');
             case $user->hasRole('reporter'):
                return redirect('/reporter');    
             case $user->hasRole('billing-officer'):
                return redirect('/billing-officer');    
             case $user->hasRole('supervisor-officer');
                return redirect('/supervisor-officer'); 
                case $user->hasRole('qcd-manager');
                return redirect('/quality-control');  
                default:
                  return redirect('/admin');
            }
            
           
        }

        return $next($request);
    }
}
