<?php namespace App\Library\ModuleGenerator;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ModuleGenerator
{

	private $filesystem;
	private $command;

	public function __construct( Command $command, Filesystem $filesystem )
	{
		$this->filesystem = $filesystem;
		$this->command = $command;
		return $this;
	}

	public function generate( $name, array $options = [] )
	{
		$this->generateMigration( $name );
		$name = $this->parseName( $name );

		foreach($this->getStubs() as $destination => $stub)
		{
			$this->createModuleFile( $name, $destination, $stub );
		}

		if( array_get($options, 'translation') === true )
		{
			$this->generateTranslationModel( $name );
		}
	}

	private function generateTranslationModel( $name )
	{
		$this->generateTranslationMigration( $name );
		$name = $this->parseName( $name ) . 'Translation';

		foreach($this->getTranslationStubs() as $destination => $stub)
		{
			$this->createModuleFile( $name, $destination, $stub );
		}
	}

	private function generateMigration( $name )
	{
		$table = Str::plural( snake_case( $name ) );
		$migrationName = $table . '_table';

		$this->command->call( 'make:migration', [
			'name' => $migrationName,
			'--create' => $table
			]);
	}

	private function generateTranslationMigration( $name )
	{
		$translated = Str::singular( snake_case( $name ) );
		$translatedTable = Str::plural( snake_case( $name ) );
		$migrationName = $translated . '_translations_table';
		$migrationClass = ucfirst( camel_case( $migrationName ) );
		$migrationFilename = date('Y_m_d') . '_' . (date('His') + 5) .'_' . $migrationName;

		foreach($this->getTranslationMigrationStubs() as $destination => $stub)
		{
			$destination = $this->replaceDestination( $migrationFilename, $destination );
			$content = $this->replaceStubContent(['%translated%', '%migrationClass%', '%translatedTable%'], [$translated, $migrationClass, $translatedTable], $stub);
			$this->saveFile( $destination, $content );
		}
	}

	private function createModuleFile( $name, $destination, $stub )
	{
		$content = $this->replaceStubContent( '%name%', $name, $stub );
		$destination = $this->replaceDestination( $name, $destination );
		$this->saveFile( $destination, $content );
	}

	private function saveFile( $destination, $content )
	{
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

	private function replaceStubContent( $what, $replacement, $stub )
	{
		return str_replace($what, $replacement, $this->getStubContent( $stub ));
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

	private function getTranslationStubs()
	{
		return [
			app_path() . '/Models/%name%/%name%.php' => __DIR__ . '/stubs/Model.stub',
			app_path() . '/Models/%name%/%name%Observer.php' => __DIR__ . '/stubs/Observer.stub'
		];
	}

	private function getTranslationMigrationStubs()
	{
		return [
			base_path() . '/database/migrations/%name%.php' => __DIR__ . '/stubs/ModelTranslationMigration.stub',
		];
	}
}