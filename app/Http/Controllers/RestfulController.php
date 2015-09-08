<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class RestfulController extends Controller
{
	public function index()
	{
		return json( $this->repository->all() );
	}

	public function show( $id )
	{
		return json( $this->repository->show( $id ) );
	}

	public function store( Request $request )
	{
		return json( $this->repository->store( $request->all() ) );
	}

	public function update( Request $request, $id )
	{
		return json( $this->repository->update( $request->all(), $id ) );
	}

	public function delete( $id )
	{	
		return json( $this->repository->delete( $id ) );
	}
}