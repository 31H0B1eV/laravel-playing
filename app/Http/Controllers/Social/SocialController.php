<?php

namespace App\Http\Controllers\Social;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\User;
use App\Social;
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

        if(get_class($authUser) == 'App\User') { // fails on: !$user->email
            Auth::login($authUser, true);
            return redirect()->route('home');
        }
        dd($authUser);

        return redirect('register');
    }

    /**
     * As described from function name.
     * @param  [Socialite] $user    [Socialite record]
     * @param  [String] $provider   [Socialite auth provider]
     * @return [App\User]           [instanceOf App\User]
     */
    public function findOrCreateUser($user, $provider)
    {        
        /** 
        * Check for Auth::user() for future possibility link existing account to social
        * if no user email provided from social account registration must be provided 
        * from main registration form.
        */
        if(!$user->email && !Auth::user()) return;

        /**
         * Check if user with provided email already exists.
         * @var [type]
         */
        $existingUser = User::where('email', '=', $user->email)
            ->first();

        if($existingUser) {
            /**
             * Get social record for existing user.
             * @var [type]
             */
            $authUserHasProvider = Social::where('user_id', '=', $existingUser->id)
                ->where('provider_name', '=', $provider)
                ->get();

            if($authUserHasProvider->count() == 0) {
                /**
                 * If social record for existing user empty
                 * create it.
                 */
                return Social::create([
                    'user_id' => $existingUser->id,
                    'provider_name' => $provider,
                    'provider_user_id' => $user->id,
                    'provider_token' => $user->token
                ]);
            }

            /**
             * If social record for existing user exists
             * update token value.
             */
            Social::where('user_id', '=', $existingUser->id)
                ->where('provider_name', '=', $provider)
                ->update(['provider_token' => $user->token]);

            return $existingUser;
        }        

        /**
         * If no user with provided email exists
         * create record.
         */
        User::create([
            'name'        => $user->name ?? '',
            'username'    => $user->email,
            'email'       => $user->email,
            'password'    => bcrypt($this->defaultPassword)
        ]);

        /**
         * Get previously created record.
         * @var [type]
         */
        $currentUser = User::where('email', '=', $user->email)
            ->first();

        /**
         * Update social record for previously created record.
         */
        Social::create([
                'user_id' => $currentUser->id,
                'provider_name' => $provider,
                'provider_user_id' => $user->id,
                'provider_token' => $user->token
            ]);

        return $currentUser;
    }

    /**
     * Unlink social record
     * by simple token remove.
     * 
     * @param  [String] $provider
     * @return [redirect]
     */
    public function forget($provider)
    {
        // TODO: implement it
    }
}
