<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

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
    public function index(Request $request)
    {
        if(\Auth::check() && \Auth::user()->id == $request->id) {
            $user = User::where('id', '=', $request->id)->first();

            return view('home', ['user' => $user, 'providers' => $user->social()->get()]);
        }

        return view('home');
    }
}
