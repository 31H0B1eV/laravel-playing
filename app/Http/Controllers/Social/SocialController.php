<?php

namespace App\Http\Controllers\Social;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Socialite;

class SocialController extends Controller
{
    protected $defaultPassword = 'secret';

    public function login($provider)
    {
        return Socialite::with($provider)
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
             ])->redirect();
    }

    public function redirect($provider)
    {
        $user = Socialite::with($provider)->user();

        $authUser = $this->findOrCreateUser($user, $provider);

        if(get_class($authUser) == 'App\User') {
            Auth::login($authUser, true);
            return redirect()->route('home');
        }

        return redirect('register');
    }

    public function findOrCreateUser($user, $provider)
    {        
        $existingUser = User::where('email', '=', $user->email)->first();
        if(!$user->email && !Auth::user()) return;

        if(Auth::user()) {
            $authUser = User::where('id', '=', Auth::user()->id)->first();
            $authUser[$provider . '_token'] = $user->token;
            $authUser->save();

            return $authUser;
        } else if ($existingUser) {
            return $existingUser;
        }        

        return User::create([
            'name'        => $user->name ?? '',
            'username'    => $user->email,
            'email'       => $user->email,
            'password'    => bcrypt($this->defaultPassword),
            $provider . '_token'    => $user->token,
        ]);
    }

    public function forget($provider)
    {
        $user = User::where('id', '=', Auth::user()->id)->first();
        $user[$provider . '_token'] = '';
        $user->save();

        return redirect()->route('home');
    }
}
