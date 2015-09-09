<?php

function json( $data )
{
	$status = 404;
	if($data)
	{
		$status = 200;
	}

	return response()->json($data, $status);
}

function resourceRoute( $name, $controller )
{
	Route::get( $name, $controller . '@' . 'index' );
	Route::get( $name . '/{id}', $controller . '@' . 'show' )->where( 'id', '[0-9]+' );
	Route::post( $name, $controller . '@' . 'store' );
	Route::put( $name . '/{id}', $controller . '@' . 'update' )->where( 'id', '[0-9]+' );
	Route::delete( $name . '/{id}', $controller . '@' . 'delete' )->where( 'id', '[0-9]+' );
	Route::controller( $name, $controller );
}