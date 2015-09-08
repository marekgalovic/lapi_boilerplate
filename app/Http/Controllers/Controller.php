<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $repository;

    public function __construct()
    {
    	$this->repository = $this->getRepository();
    }

    private function getRepository()
    {
    	$called = class_basename( get_called_class() );
    	$base  = str_replace('Controller', '', $called);
    	$repositoryClass = 'App\Models\\' . $base . '\\' . $base . 'Repository';
    	return new $repositoryClass;
    }
}
