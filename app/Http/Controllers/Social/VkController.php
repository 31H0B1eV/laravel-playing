<?php

namespace App\Http\Controllers\Social;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Socialite;

class VkController extends Controller
{
    public function oauth2()
    {        
        return Socialite::with('vkontakte')
            ->scopes([
                 'friends',
                 'photos',
                 'audio',
                 'video',
                 'pages',
                 '+256',
                 'status',
                 'notes',
                 'wall',
                 'ads',
                 'offline',
                 'docs',
                 'groups',
                 'notifications',
                 'stats',
                 'email',
                 'market',
             ])
            ->redirect();
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
            redirect()->route('home'); // TODO: add error message
        }

        return redirect()->route('home');
    }

    public function forget()
    {
        $user = User::where('id', '=', Auth::user()->id)->first();
        $user->vk_token = '';
        $user->save();

        return redirect()->route('home');
    }
}
