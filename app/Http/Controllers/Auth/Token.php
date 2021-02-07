<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\TokenRequest;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class Token extends Controller
{


    public function __invoke(TokenRequest $request)
    {
        throw_unless(
            is_null($request->user()),
            ValidationException::withMessages(['user'=> 'already logged in'])
        );
        throw_unless(
            $user = User::firstWhere(['email' => $request->get('email'),]),
            ValidationException::withMessages(['email'=> 'wrong email'])
        );
        throw_unless(
            \Hash::check($request->get('password'), $user->password),
            ValidationException::withMessages(['password' => 'wrong password'])
        );
        return response()->json(['token' => $user->createToken($request->device_name)->plainTextToken]);
    }


}
