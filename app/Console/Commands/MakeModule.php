<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use App\Library\ModuleGenerator\ModuleGenerator;
use Symfony\Component\Console\Input\InputArgument;

class MakeModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {name} {--translation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create application module';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->filesystem = $files;
    }

    public function fire()
    {
        $generator = new ModuleGenerator( $this, $this->filesystem );
        $generator->generate( $this->argument('name'), ['translation' => $this->option('translation')] );
    }
}
