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

		$swagger = \Swagger\scan($directory, [
			'exclude' => $exclude
		]);
		return response((string) $swagger, 200, [
			'Content-Type' => 'application/json'
		]);
	}
}
