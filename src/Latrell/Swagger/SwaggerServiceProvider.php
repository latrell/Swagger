<?php
namespace Latrell\Swagger;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class SwaggerServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('latrell/swagger');

        $this->app->bind('swagger::install', function ($app)
        {
            return new Installer();
        });
        $this->commands(array(
            'swagger::install'
        ));

        if (Config::get('app.debug')) {
            $appdir = app_path();
            $docdir = base_path(Config::get('swagger::docs-dir'));
            // $swagger = realpath(dirname(__DIR__) . '/../../') . '/vendor/zircote/swagger-php/swagger.phar';
            $swagger = base_path('vendor/zircote/swagger-php/swagger.phar');
            exec(sprintf('php "%s" "%s" -o "%s"', $swagger, $appdir, $docdir), $output, $return_var);
            if ($return_var) {
                throw new SwaggerException(join("\n", $output));
            }
            $errors = [];
            foreach ($output as $line) {
                if (preg_match('/^\[\w+\]/', $line, $matchs)) {
                    $errors[] = $line;
                }
            }
            if ($errors) {
                throw new SwaggerException(join("\n", $errors));
            }

            require __DIR__ . '/../../routes.php';
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
