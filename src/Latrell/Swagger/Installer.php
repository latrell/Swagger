<?php
namespace Latrell\Swagger;

use Illuminate\Console\Command;

class Installer extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'swagger:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pushes views to public folder';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $package_path = ltrim(str_replace(realpath(base_path()), '', realpath(__DIR__ . '/../../../')), '/\\');
        $this->call('config:publish', array(
            'package' => 'latrell/swagger',
            '--path' => $package_path . '/src/config'
        ));
        $this->call('asset:publish', array(
            'package' => 'latrell/swagger',
            '--path' => $package_path . '/public'
        ));
    }
}
