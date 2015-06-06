<?php
namespace Latrell\Swagger;

use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;

class SwaggerController extends Controller
{

    public function getIndex()
    {
        $swagger = new Swagger();

        $swagger->paths = config('latrell-swagger.paths');
        $swagger->exclude = config('latrell-swagger.exclude');
        $swagger->output = config('latrell-swagger.output');
        $swagger->suffix = config('latrell-swagger.suffix');
        $swagger->default_api_version = config('latrell-swagger.default-api-version');
        $swagger->default_swagger_version = config('latrell-swagger.default-swagger-version');
        $swagger->api_doc_template = config('latrell-swagger.api-doc-template');
        $swagger->default_base_path = config('latrell-swagger.default-base-path');

        if (is_null($swagger->default_base_path)) {
            $swagger->default_base_path = Config::get('app.url');
        }

        $swagger->fire();

        return view('latrell/swagger::index');
    }

    public function getDocs($page = 'api-docs')
    {
        $page = $page . '.json';
        $path = head((array) config('latrell-swagger.output')) . DIRECTORY_SEPARATOR . $page;
        if (! file_exists($path)) {
            App::abort(404);
        }
        $content = file_get_contents($path);
        return Response::make($content)->header('Content-Type', 'application/json');
    }
}
