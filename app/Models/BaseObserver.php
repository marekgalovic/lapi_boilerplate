<?php namespace App\Models;

class BaseObserver
{
	public function creating( $model )
	{

	}

	public function created( $model )
	{

	}

	public function updating( $model )
	{

	}

	public function updated( $model )
	{

	}

	public function deleting( $model )
	{
		$model->deleteTranslations();
	}

	public function deleted( $model )
	{

	}

	public function saving( $model )
	{

	}

	public function saved( $model )
	{
		$model->saveTranslation();
		$model->clearDefaults();
	}
}