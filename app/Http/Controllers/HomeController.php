<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        if(\Auth::user()) {
            $providers = array();
            foreach (\Auth::user()->social as $provider) {
                array_push($providers, $provider->provider_name);
            }

            return view('home', compact('providers'));
        }

        return view('home');
    }
}
