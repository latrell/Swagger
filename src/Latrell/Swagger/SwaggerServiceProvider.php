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

            $swagger = new Swagger();

            $swagger->paths = Config::get('swagger::paths');
            $swagger->exclude = Config::get('swagger::exclude');
            $swagger->output = Config::get('swagger::output');
            $swagger->suffix = Config::get('swagger::suffix');
            $swagger->default_api_version = Config::get('swagger::default-api-version');
            $swagger->default_swagger_version = Config::get('swagger::default-swagger-version');
            $swagger->api_doc_template = Config::get('swagger::api-doc-template');
            $swagger->default_base_path = Config::get('swagger::default-base-path');

            if (is_null($swagger->default_base_path)) {
                $swagger->default_base_path = Config::get('app.url');
            }

            $swagger->fire();

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
