<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use Validator;
use Redirect;
use Response;
use File;
use Exception;
use App\User;

class GoogleController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
     
    public function callback($provider)
    {
               
        $getInfo = Socialite::driver($provider)->user();
         
        $user = $this->createUser($getInfo,$provider);
     
        Auth()->login($user);
     
        return redirect()->to('/home');
     
    }
    function createUser($getInfo,$provider){
     
     $user = User::where('provider_id', $getInfo->id)->first();
     
     if (!$user) {
         $user = User::create([
            'name'     => $getInfo->name,
            'email'    => $getInfo->email,
            'provider' => $provider,
            'provider_id' => $getInfo->id
        ]);
      }
      return $user;
    }

}

