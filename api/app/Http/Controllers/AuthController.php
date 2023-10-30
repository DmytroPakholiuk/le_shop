<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(Request $request, Response $response)
    {
        // TODO finish transferring login process to API
        if (auth()->guard()->attempt($request->only('email', 'password'))) {
//            if (! $request->post("redirect") == null) {
                return redirect()->intended();
//            }
//            $response->header("Access-Control-Allow-Origin", "*");
//            return redirect($request->post("redirect"));
        }

        throw new \Exception('There was some error while trying to log you in. ');
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
