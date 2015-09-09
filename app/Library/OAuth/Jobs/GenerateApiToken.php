<?php

namespace App\Library\OAuth\Jobs;

use App\Jobs\Job;
use Carbon\Carbon;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Config\Repository as Config;
use App\Models\Token\Token;

class GenerateApiToken extends Job implements SelfHandling
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    
    private $user;
    private $expires;

    public function __construct( $user, $expires )
    {
        $this->user = $user;
        $this->expires = $expires;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $token = str_random(48);
        $expires = Carbon::now()->addSeconds($this->expires);
        $this->user->tokens()->delete();
        return $this->user->tokens()->create(['token'=>$token, 'expires'=>$expires]);
    }
}
