<?php

namespace App\Http\Controllers\Social;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Socialite;

class VkController extends Controller
{
    public function login()
    {
        return Socialite::with('vkontakte')->scopes(['email'])->redirect();
    }

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
        $user = Socialite::with('vkontakte')->user();

        $authUser = $this->findOrCreateUser($user);
        Auth::login($authUser, true);

        return redirect()->route('home');
    }

    public function findOrCreateUser($user)
    {
        $existingUser = User::where('email', '=', $user->email)->first();

        if(Auth::user()) {
            $authUser = User::where('id', '=', Auth::user()->id)->first();
            $authUser->vk_token = $user->token;
            $authUser->save();

            return $authUser;
        } else if ($existingUser) {
            return $existingUser;
        }        

        if(!$user->email) return redirect('register');
        return User::create([
            'name'        => $user->name ?? '',
            'username'    => $user->email,
            'email'       => $user->email,
            'password'    => bcrypt('secret'),
            'vk_token'    => $user->token,
        ]);
    }

    public function forget()
    {
        $user = User::where('id', '=', Auth::user()->id)->first();
        $user->vk_token = '';
        $user->save();

        return redirect()->route('home');
    }
}
