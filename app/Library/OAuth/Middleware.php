<?php

namespace App\Library\OAuth;

use Closure;
use App;
use App\Library\OAuth\Jobs\VerifyApiToken;
use Illuminate\Foundation\Bus\DispatchesJobs;

class Middleware
{

    use DispatchesJobs;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
    protected $auth;
    
    public function __construct()
    {
        $this->auth = App::make('oauth');
    }

    public function handle($request, Closure $next)
    {
        $token = $request->header('api-token');
        $user = $this->dispatch(new VerifyApiToken( $token ));
        if($user)
        {
            $this->auth->set( $user );
            return $next($request);
        }
        return response(null, 403);
    }
}
