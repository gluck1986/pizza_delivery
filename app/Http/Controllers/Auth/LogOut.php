<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;


class LogOut extends Controller
{


    public function __invoke(Request $request)
    {
       // $request->user()->currentAccessToken()->delete();
        \Auth::guard('web')->logout();
        $request->user()->currentAccessToken()->delete();
        /** @var User $user */
        $user = $request->user();
        /** @var PersonalAccessToken $token */
        $token = $user->currentAccessToken();
        $token->
        $user->tokens()->delete();
//
//        $currentToken->forceDelete();

        return response()->json(['success' => true]);
    }


}
