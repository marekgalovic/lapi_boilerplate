<?php namespace App\Library\DBTranslator;

use App\Models\Language\Language;

class DBTranslator
{
	private $lang = null;

	public function setLang( $shortcut = null )
	{	
		if($shortcut === null)
		{
			$this->lang = $this->getDefault();
		}

		$this->lang = Language::where('shortcut', $shortcut)->first();
		if(!$this->lang)
		{
			throw new InvalidLanguageException( "Language [" . $shortcut . "] was not found");
		}
		return $this;
	}

	public function getDefault()
	{
		return Language::where('is_default', true)->first();
	}

	public function getLang()
	{
		return $this->lang;
	}

	public function getLangId()
	{
		return $this->getLang()->id;
	}
}