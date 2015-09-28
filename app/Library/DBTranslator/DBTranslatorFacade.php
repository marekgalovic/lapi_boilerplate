<?php namespace App\Library\DBTranslator;

use Illuminate\Support\Facades\Facade;

class DBTranslatorFacade extends Facade
{
	protected static function getFacadeAccessor()
    {
        return 'dbtranslator';
    }
}