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

        return View::make('swagger::index');
    }

    public function getDocs($page = 'api-docs.json')
    {
        $path = base_path(Config::get('swagger::output') . '/' . $page);
        if (! file_exists($path)) {
            App::abort(404);
        }
        $content = file_get_contents($path);
        return Response::make($content)->header('Content-Type', 'application/json');
    }
}
