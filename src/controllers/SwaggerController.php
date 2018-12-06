<?php
namespace Latrell\Swagger;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;

class SwaggerController extends Controller
{

	public function getIndex()
	{
		return view('latrell/swagger::index');
	}

	public function getDocs($page = 'api-docs.json')
	{
		$directory = config('latrell-swagger.paths');
		$exclude = config('latrell-swagger.exclude');

        $constants = config('latrell-swagger.constants');
        self::defineConstants($constants);

		$swagger = \Swagger\scan($directory, [
			'exclude' => $exclude
		]);
		return response((string) $swagger, 200, [
			'Content-Type' => 'application/json'
		]);
	}

    protected static function defineConstants(array $constants)
    {
        if (!empty($constants)) {
            foreach ($constants as $key => $value) {
                defined($key) || define($key, $value);
            }
        }
	}
}
