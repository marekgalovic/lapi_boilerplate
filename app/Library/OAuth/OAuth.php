<?php namespace App\Library\OAuth;

use Config;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Library\OAuth\Jobs\GenerateApiToken;

class OAuth
{

	use DispatchesJobs;

	private $hash;
	private $config;
	private $model;
	private $user;

	public function __construct( $app )
	{
		$this->config = $app->make('config');
		$this->hash = $app->make('hash');
		$this->setModel( $this->config->get('auth.model') );
	}

	public function attempt( $credentials )
	{
		$user = $this->model->where('email', array_get($credentials, 'email'))->first();
		if($user)
		{
			if($this->hash->check(array_get($credentials, 'password'), $user->password))
			{
				return $this->dispatch( new GenerateApiToken($user, $this->config->get('auth.expires')) );
			}
		}
		return false;
	}

	public function logout()
	{
		$this->model->tokens()->delete();
	}

	public function set( $user )
	{
		$this->user = $user;
		return $this;
	}

	public function get()
	{
		return $this->user;
	}

	private function setModel( $model )
	{
		$this->model = new $model;
	}
}