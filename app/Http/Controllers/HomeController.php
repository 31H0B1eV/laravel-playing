<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Socialite;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->vk_token) {
            return view('home', ['user' => Auth::user()]);
        }

        return view('home');
    }

    public function authorize_vk()
    {        
        return Socialite::with('vkontakte')->redirect();
    }

    public function redirect()
    {
        try {
            $vk_token = Socialite::with('vkontakte')->user()->token; // get token

            /* insert token into user record */
            $user = User::where('id', '=', Auth::user()->id)->first();
            $user->vk_token = $vk_token;
            $user->save();
        } catch(\Exception $e) {
            abort(401);
        }

        return redirect()->route('home');
    }
}
