<?php namespace App\Library\DBTranslator;

use Closure;
use DBTranslator;

class Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	DBTranslator::setLang( $request->input('lang') );
        return $next($request);
    }
}
