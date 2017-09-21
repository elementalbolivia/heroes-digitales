<?php
namespace App\Traits;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTFactory;

trait JwtTraitAuth{
	public static function emailConfirmationAuth(Usuario $user){
		$payload = JWTFactory::sub($user->id)->email(['email' => $user->correo])->make();
		$token = JWTAuth::encode($payload);
		return response()->json(['token'	=> $token]);
	}
}