<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OAuth;

class AuthController extends Controller
{

	public function getLogged()
	{
		return response()->json(Oauth::get());
	}

	public function postLogin(Request $request)
	{
		$token = OAuth::attempt(['email'=>$request->get('email'), 'password'=>$request->get('password')]);
		if($token)
		{
			$token->load('user');
			return response($token, 200);
		}
		return response(null, 401);
	}

	public function getLogout()
	{
		OAuth::logout();
		return response(null, 200);
	}
}