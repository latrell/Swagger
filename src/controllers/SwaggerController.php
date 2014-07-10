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
