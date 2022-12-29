<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Auth;
use Illuminate\Http\Request;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    
    // protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
     
     
      public function redirectTo() {
        $user = Auth::user();
        switch(true) {
            case $user->hasRole('teacher'):
                return '/teacher';
             case $user->hasRole('admission-officer'):
                return '/admission-officer';    
             case $user->hasRole('demonstration-officer'):
                return '/demonstration-officer';
            case $user->hasRole('reporter'):
                return '/reporter';    
             case $user->hasRole('billing-officer'):
                return '/billing-officer';    
             case $user->hasRole('supervisor-officer'):
                return '/supervisor-officer';  
            case $user->hasRole('super-admin'):
                return '/super-admin';
            case $user->hasRole('qcd-manager'):
                    return '/quality-control';  
            case $user->hasRole('parent'):
                return '/parent';     
            default:
                return '/admin';
        }
    }
     
     
       protected function authenticated(Request $request, $user)
       {
        
         auth()->user()->update(['fcm_token' => $request->fcm_token]); 
     
        if(auth()->user()->hasRole('teacher')){
            
         return redirect()->route('teacherpanel.dasboard.index');
         
        }else if(auth()->user()->hasRole('admission-officer')){
            
             return redirect()->route('admissionpanel.dasboard.index');
        }
        else if(auth()->user()->hasRole('supervisor-officer')){
            
             return redirect()->route('supervisorpanel.dasboard.index');
        }
        else if(auth()->user()->hasRole('demonstration-officer')){
            
             return redirect()->route('demonstrationpanel.dasboard.index');
        }
         else if(auth()->user()->hasRole('qcd-manager')){
            
             return redirect()->route('qualitycontrolpanel.dasboard.index');
        }
        else if(auth()->user()->hasRole('reporter')){
            
             return redirect()->route('reporter.dasboard.index');
        }
         else if(auth()->user()->hasRole('parent')){
            
             return redirect()->route('parentpanel.dasboard.index');
        }
        else{
             return redirect()->route('dashboard');
        }
        
       
    }
    
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
