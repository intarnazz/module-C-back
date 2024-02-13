<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class AuthController extends Controller
{
  public function login(Request $request)
  {
    $user = User::all()->where("email", $request->email)->first();
    if (!$user) {
    }
    if ($user->password = $request->password) {
      $user->remember_token = $user->createToken('remember_token')->plainTextToken;
      $user->save();
      $res = [
        'data' => [
          'token' => [$user->remember_token]
        ],
        'status' => 'ok'
      ];
      return response()->json($res)->setStatusCode(200);
    }
  }
  public function logout(Request $request)
  {
    $res = ['status' => 'ok'];
    $token = $request->header('Authorization');
    $token = str_replace('Bearer ','', $token);
    $user = User::all()->where('remember_token', $token)->first();
    if ($user) {
      $user->remember_token = '';
      $user->save();
    }
    return response()->json($res)->setStatusCode(200);
  }
}
