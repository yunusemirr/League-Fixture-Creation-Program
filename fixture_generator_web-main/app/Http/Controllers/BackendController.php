<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Backend\BaseController;
use App\Http\Controllers\Backend\BasePattern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BackendController extends BaseController
{
    use BasePattern;

    public function __construct()
    {
        $this->page = 'backend';
        $this->title = 'backend';

        parent::__construct();
    }

    public function showLogin(){
        if(Auth::check()){
            return redirect()->route('panel.show');
        }
        return view('backend.login');
    }

    public function postLogin(Request $request){
        $request->validate([
            'tc' => 'required|string|exists:users,tc',
            'password' => 'required|string',
        ],[],[
            'tc' => __('models.user.tc'),
            'password' => __('models.user.password')
        ]);

        $user = Auth::attempt([
            'tc' => $request->tc,
            'password' => $request->password,
        ]);

        if(!$user){
            return redirect()->back()->with('error', __('messages.auth.invalid_credentials'));
        }

        if($request->session()->has('redirect_after')){
            //check if this valid route
            $route = $request->session()->get('redirect_after');
            if(route($route)){
                return redirect()->route($route);
            }
        }

        return redirect()->route('panel.show');
    }

    public function postLogout(){
        Auth::logout();
        return redirect()->route('login.show')->with('success', __('messages.auth.logout_success'));
    }

    public function toggleLocale(Request $request){
        session()->put('locale', $request->locale);
        return redirect()->back()->with('success', __('messages.backend.locale_changed'));
    }
}
