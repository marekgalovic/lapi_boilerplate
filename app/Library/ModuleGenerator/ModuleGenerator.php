<?php namespace App\Library\ModuleGenerator;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class ModuleGenerator
{

	public function __construct( Filesystem $filesystem )
	{
		$this->filesystem = $filesystem;
		return $this;
	}

	public function generate( $name )
	{
		$name = $this->parseName( $name );
		foreach($this->getStubs() as $destination => $stub)
		{
			$this->createModuleFile( $name, $destination, $stub );
		}
	}

	private function createModuleFile( $name, $destination, $stub )
	{
		$content = $this->replaceStubContent( $name, $stub );
		$destination = $this->replaceDestination( $name, $destination );
		if(!$this->filesystem->exists($destination))
		{
			$this->ensureDirectory( $destination );
			$this->filesystem->put( $destination, $content );
		}
	}

	private function getStubContent( $path )
	{
		return $this->filesystem->get( $path );
	}

	private function replaceStubContent( $name, $stub )
	{
		return str_replace('%name%', $name, $this->getStubContent( $stub ));
	}

	private function replaceDestination( $name, $destination )
	{
		return str_replace('%name%', $name, $destination);
	}

	private function parseName( $name )
	{
		return ucfirst(Str::singular($name));
	}

	private function ensureDirectory( $path )
	{
		if( !$this->filesystem->isDirectory( dirname($path) ) )
		{
			$this->filesystem->makeDirectory( dirname($path), 0777, true, true );
		}
	}

	private function getStubs()
	{
		return [
			app_path() . '/Http/Controllers/%name%Controller.php' => __DIR__ . '/stubs/Controller.stub',
			app_path() . '/Models/%name%/%name%.php' => __DIR__ . '/stubs/Model.stub',
			app_path() . '/Models/%name%/%name%Observer.php' => __DIR__ . '/stubs/Observer.stub',
			app_path() . '/Models/%name%/%name%Repository.php' => __DIR__ . '/stubs/Repository.stub'
		];
	}
}