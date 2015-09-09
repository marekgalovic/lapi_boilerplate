<?php namespace App\Models\Token;

use App\Models\BaseModel;

class Token extends BaseModel
{
	protected $fillable = ['token', 'expires'];

	public function user()
	{
		return $this->belongsTo('App\Models\User\User');
	}
}