<?php namespace App\Library\OAuth;

use Illuminate\Support\Facades\Facade;

class OAuthFacade extends Facade
{
	protected static function getFacadeAccessor()
    {
        return 'oauth';
    }
}