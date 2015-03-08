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
		if (config('latrell/swagger/config.enable')) {
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
		$configPath = __DIR__ . '/../../config/config.php';
		$this->mergeConfigFrom($configPath, 'latrell/swagger/config');
		$this->publishes([
			$configPath => config_path('latrell/swagger/config.php')
		]);
	}
}
