<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class EmailController extends Controller
{
    //
    public function verify($token)
    {
        $user = User::where('confirmation_token',$token)->firstOrFail();

        $user->is_active = 1;
        $user->confirmation_token = str_random(40);
        $user->save();

        Auth::login($user);
        return redirect('/home');
    }
}