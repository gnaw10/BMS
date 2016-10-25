<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            /*if ($request->input('api_token')) {
                return User::where('api_token', $request->input('api_token'))->first();
            }*/
            
            
            $api_token = explode('-', $request->input('api_token'));
            if ($request->input('api_token')) {
                $api_token = explode('-', $request->input('api_token'));
                $username = $api_token[0];
                $apikey = $api_token[1];
                $apikey_id = $api_token[2];
                $user = \App\Model\User::where([
                    ['apikey', $apikey],
                    ['id', $apikey_id],
                ])->first();
                if($user && $user->username === $username) return $user;
            }   


        if ($request->header('Api-Token')) {
                $api_token = explode('-', $request->header('Api-Token'));
                 //dd($api_token);
                if(count($api_token) == 3) {
                    $user = \App\Model\User::where([
                        ['apikey', $api_token[1]],
                        ['id', $api_token[2]],
                    ])->first();
                    //dd($user);
                    if($user) {
                        if($user && $user->username === $api_token[0]) {
                            return $user;
                        }
                    }
                }
            }
        });

    }
}
