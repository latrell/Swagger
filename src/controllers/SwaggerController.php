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
        return View::make('swagger::index');
    }

    public function getDocs($page = 'index.php')
    {
        $path = base_path(Config::get('swagger::docs-dir') . '/' . $page);
        if (! file_exists($path)) {
            App::abort(404);
        }
        $content = '';
        if (array_get(pathinfo($page), 'extension') === 'php') {
            ob_start();
            require $path;
            $content = ob_get_clean();
        } else {
            $content = file_get_contents($path);
        }
        return Response::make($content);//->header('Content-Type', 'application/json');
    }
}
