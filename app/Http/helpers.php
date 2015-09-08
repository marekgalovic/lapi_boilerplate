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
	Route::resource( $name, $controller );
	Route::controller( $name, $controller );
}