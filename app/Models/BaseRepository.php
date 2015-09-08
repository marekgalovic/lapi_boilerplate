<?php namespace App\Models;

abstract class BaseRepository
{

	protected $model;

	public function __construct()
	{
		$this->model = $this->getModelInstance();
	}

	private function getModelInstance()
	{	
		$called = class_basename( get_called_class() );
		$base = str_replace('Repository', '', $called);
		$model = 'App\Models\\' . $base . '\\' . $base;
		return new $model;
	}

	public function all()
	{
		return $this->model->all();
	}

	public function show( $id )
	{
		return $this->model->find( $id );
	}

	public function store( array $data )
	{
		return $this->model->create( $data );
	}

	public function update( array $data, $id )
	{
		if( $model = $this->model->find( $id ) )
		{
			return $model->update( $data );
		}
		return null;
	}

	public function delete( $id )
	{
		return $this->model->delete( $id ); 
	}
}