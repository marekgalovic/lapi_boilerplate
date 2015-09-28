<?php namespace App\Models\Language;

use App\Models\BaseModel;

class Language extends BaseModel
{
	protected $fillable = ['name', 'shortcut', 'icon', 'is_default'];
	
}