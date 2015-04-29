<?php
namespace Latrell\Swagger;

use Illuminate\Support\ServiceProvider;

class SwaggerServiceProvider extends ServiceProvider
{

	/**
	 * boot process
	 */
	public function boot()
	{
		$this->publishes([
			__DIR__ . '/../../config/config.php' => config_path('latrell-swagger.php')
		]);

		$this->loadViewsFrom(__DIR__ . '/../../views', 'latrell/swagger');

		$this->publishes([
			__DIR__ . '/../../views' => base_path('resources/views/vendor/latrell/swagger')
		], 'views');

		$this->publishes([
			__DIR__ . '/../../../public' => public_path('vendor/latrell/swagger')
		], 'public');

		if (config('latrell-swagger.enable')) {
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
		$this->mergeConfigFrom(__DIR__ . '/../../config/config.php', 'latrell-swagger');
	}
}
