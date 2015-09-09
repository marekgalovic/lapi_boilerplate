<?php

namespace App\Library\OAuth\Jobs;

use App\Jobs\Job;
use Carbon\Carbon;
use Illuminate\Contracts\Bus\SelfHandling;
use App\Models\Token\Token;

class VerifyApiToken extends Job implements SelfHandling
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    
    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $token = Token::with('user')->where('token', $this->token)->first();  
        if($token)
        {
            if($token->expires > Carbon::now())
            {
                return $token->user;
            }
        }
        return false;
    }
}
