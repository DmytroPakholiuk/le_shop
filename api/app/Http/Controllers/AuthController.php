<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (auth()->guard()->attempt($request->only('email', 'password'))) {
            return redirect()->intended();
        }

        throw new \Exception('There was some error while trying to log you in. '
            . Hash::make($request->input('password')));
    }

    public function signup(Request $request)
    {
        $data = $request->only('email', 'name', 'password');
        if (!$request->validate([
            'email' => 'email|required|max:255|unique:frontend_users',
            'name' => 'required|max:255',
            'password' => 'required|min:8|max:255'
        ])){
//            $errors =
            return view('signup');
        }
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['hash']);

        return $this->login($request);
    }

}
