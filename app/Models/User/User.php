<?php namespace App\Models\User;

use App\Models\BaseModel;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends BaseModel implements AuthenticatableContract
{
	use Authenticatable;

	protected $fillable = ['name', 'surname', 'email', 'password'];

	protected $hidden = ['password'];

	public function tokens()
	{
		return $this->hasMany('App\Models\Token\Token');
	}
}